<?php

use App\Controllers\HomeController;
use App\Controllers\GradeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;


Flight::group('', function () {

    // Home view
    Flight::route('/', [HomeController::class, 'index'], false, 'home');

    // Resource routes
    Flight::resource('/grade', \App\Controllers\GradeController::class);
    Flight::resource('/user', \App\Controllers\UserController::class);
    Flight::resource('/wish', \App\Controllers\WishController::class);
    Flight::resource('/chore', \App\Controllers\ChoreController::class);
    Flight::resource('/reward', \App\Controllers\RewardController::class);
    Flight::resource('/transaction', \App\Controllers\TransactionController::class);

    // Auth routes
    Flight::post('/login', [AuthController::class, 'login'], false, 'authenticate');
    Flight::route('/logout', [AuthController::class, 'logout'], false, 'logout');
    Flight::route('/login', [AuthController::class, 'index'], false, 'login');

    // Dashboard goal update
    Flight::post('/set-goal', [HomeController::class, 'setGoal'], false, 'set.goal');

    // Custom/extra actions
    Flight::post('/wish/@id/fulfill', [\App\Controllers\WishController::class, 'fulfill'], false, 'wish.fulfill');
    Flight::post('/chore/@id/claim', [\App\Controllers\ChoreController::class, 'claim'], false, 'chore.claim');
    Flight::post('/chore/@id/approve', [\App\Controllers\ChoreController::class, 'approve'], false, 'chore.approve');
    Flight::post('/reward/@id/claim', [\App\Controllers\RewardController::class, 'claim'], false, 'reward.claim');
    Flight::post('/reward/@id/approve', [\App\Controllers\RewardController::class, 'approve'], false, 'reward.approve');
    Flight::post('/transaction/@id/approve', [\App\Controllers\TransactionController::class, 'approve'], false, 'transaction.approve');
    Flight::post('/transaction/@id/fulfill', [\App\Controllers\TransactionController::class, 'fulfill'], false, 'transaction.fulfill');

}, [new \App\Middlewares\AuthGate()]);