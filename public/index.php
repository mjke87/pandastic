<?php

// ----------------------------------------------------
// Register the session service
// ----------------------------------------------------
use flight\Session;
$app = Flight::app();
$app->register('session', Session::class);

// ----------------------------------------------------
// Load helpers
// ----------------------------------------------------
require_once __DIR__ . '/helpers.php';

// ----------------------------------------------------
// Routing
// ----------------------------------------------------
require __DIR__ . '/routes.php';


// Basic error handling
Flight::map('notFound', function () {
    render_layout('404');
});

Flight::map('error', function (Throwable $th) {
    error_log("Application Error: " . $th->getMessage() . " on line " . $th->getLine() . " in " . $th->getFile());
    render_layout('error', ['message' => 'An unexpected error occurred. Please try again. If the problem persists, contact support.']);
});

// Configure the views directory
Flight::set('flight.views.path', config('app.templates_dir'));

// ----------------------------------------------------
// Initialize Flight authentication and permissions
// ----------------------------------------------------
Flight::before('start', function(&$params, &$output){
    \App\Middlewares\AuthMiddleware::handle();

    // Set the current user in Flight
    $user = \App\Models\User::get($_SESSION['user_id'] ?? null);
    Flight::set('user', $user);

    // Load permissions matrix
    $permissions = config('permissions');

    // Setup permissions
    $userRole = $user->role ?? 'guest';
    $permission = new \flight\Permission($userRole);
    $capabilities = array_unique(array_merge(...array_values($permissions)));

    // Define the capability rules
    foreach ($capabilities as $cap) {
        $permission->defineRule($cap, function($role) use ($permissions, $cap) {
            return in_array($cap, $permissions[$role] ?? []);
        });
    }

    // Always define 'loggedIn'
    $permission->defineRule('loggedIn', function($role) {
        return $role !== 'guest';
    });

    Flight::set('permission', $permission);
});

// Start the Flight application
Flight::start();