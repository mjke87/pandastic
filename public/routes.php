<?php

use App\Controllers\HomeController;
use App\Controllers\GradeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;


Flight::group('', function () {

    // Home view
    Flight::route('GET /', [HomeController::class, 'index']);

    // Grade views
    Flight::route('GET /grades', [GradeController::class, 'index']);
    Flight::route('GET /grade/create', [GradeController::class, 'createForm']);
    Flight::route('GET /grade/edit/@id', [GradeController::class, 'editForm']);
    Flight::route('GET /grade/@id', [GradeController::class, 'view']);

    // Grade actions
    Flight::route('POST /grade', [GradeController::class, 'create']);
    Flight::route('PUT /grade/@id', [GradeController::class, 'edit']);
    Flight::route('DELETE /grade/@id', [GradeController::class, 'delete']);

    // User views
    Flight::route('GET /users', [UserController::class, 'index']);
    Flight::route('GET /user/create', [UserController::class, 'createForm']);
    Flight::route('GET /user/edit/@id', [UserController::class, 'editForm']);
    Flight::route('GET /user/@id', [UserController::class, 'view']);

    // User actions
    Flight::route('POST /user', [UserController::class, 'create']);
    Flight::route('PUT /user/@id', [UserController::class, 'edit']);
    Flight::route('DELETE /user/@id', [UserController::class, 'delete']);

    // Auth routes
    Flight::route('GET /login', [AuthController::class, 'loginForm']);
    Flight::route('POST /login', [AuthController::class, 'login']);
    Flight::route('GET /logout', [AuthController::class, 'logout']);

    // Dashboard goal update
    Flight::route('POST /set-goal', function() {
        $user = current_user();
        $userArr = (array)$user;
        $user_id = isset($userArr['id']) ? $userArr['id'] : null;
        $goal = isset($_POST['goal']) ? intval($_POST['goal']) : 10;
        if ($user_id) {
            \App\Models\User::update($user_id, ['goal' => $goal]);
            // Update session user object
            $user->goal = $goal;
            \Flight::set('user', $user);
        }
        \Flight::redirect('/');
    });

}, [new \App\Middlewares\AuthGate()]);