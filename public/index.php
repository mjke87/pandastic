<?php

session_start();


// ----------------------------------------------------
// Helper: Render with layout and CSS framework
// ----------------------------------------------------
function render_view($view, $params = []) {
    // Convert dot notation to path and add .php extension
    $viewPath = str_replace('.', '/', $view) . '.php';
    Flight::render($viewPath, $params, 'content');
    Flight::render('layout', [
        'title' => config('app.app_name'),
        'css_framework' => [
            'https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.cyan.min.css',
            //'https://cdn.jsdelivr.net/npm/@tabler/core@1.3.2/dist/css/tabler.min.css',
        ],
        'js_framework' => [
            'https://cdn.jsdelivr.net/npm/@picocss/pico@2/js/pico.min.js',
            //'https://cdn.jsdelivr.net/npm/@tabler/core@1.3.2/dist/js/tabler.min.js',
        ],
        'theme' => Flight::get('theme') ?? 'light',
    ]);
}

// ----------------------------------------------------
// Helper: Get current user
// ----------------------------------------------------
function current_user() {
    return \App\Models\User::current();
}

// ----------------------------------------------------
// Helper: Check user permission
// ----------------------------------------------------
function user_can($cap) {
    $permission = Flight::get('permission');
    if (!$permission) {
        return false;
    }
    return $permission->has($cap);
}

// ----------------------------------------------------
// Helper: Load config file from config folder (dot notation)
// ----------------------------------------------------
function config($key) {
    static $configs = [];

    $parts = explode('.', $key);
    $file = array_shift($parts);

    // Only load once per file
    if (!isset($configs[$file])) {
        $path = APP_ROOT . '/config/' . $file . '.php';
        if (file_exists($path)) {
            $configs[$file] = require $path;
        } else {
            $configs[$file] = [];
        }
    }

    $value = $configs[$file];
    foreach ($parts as $part) {
        if (is_array($value) && array_key_exists($part, $value)) {
            $value = $value[$part];
        } else {
            return null;
        }
    }
    return $value;
}

// ----------------------------------------------------
// Routing
// ----------------------------------------------------
require __DIR__ . '/routes.php';


// Basic error handling
Flight::map('notFound', function () {
    render_view('404');
});

Flight::map('error', function (Throwable $th) {
    error_log("Application Error: " . $th->getMessage() . " on line " . $th->getLine() . " in " . $th->getFile());
    render_view('error', ['message' => 'An unexpected error occurred. Please try again. If the problem persists, contact support.']);
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