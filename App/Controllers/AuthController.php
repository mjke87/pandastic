<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    public static function loginForm() {
        self::render('auth.login', []);
    }

    public static function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = null;
        if ($username && $password) {
            $users = User::all();
            foreach ($users as $user) {
                if ($user['username'] === $username && password_verify($password, $user['password'])) {
                    \Flight::session()->set('user_id', $user['id']);
                    \Flight::session()->set('username', $user['username']);
                    \Flight::redirect('/');
                    return;
                }
            }
            $error = 'Invalid username or password.';
        } else {
            $error = 'Username and password are required.';
        }
        self::render('auth.login', ['message' => $error]);
    }

    public static function logout() {
        \Flight::session()->destroy();
        self::render('auth.logout', []);
    }
}
