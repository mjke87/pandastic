<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller {

    public function index() {
        $this->render('auth.login', []);
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = null;
        if ($username && $password) {
            $users = User::all();
            foreach ($users as $user) {
                if ($user->username === $username && password_verify($password, $user->password)) {
                    $this->session()->set('user_id', $user->id);
                    $this->session()->set('username', $user->username);
                    $this->redirect('/');
                    return;
                }
            }
            $error = 'Invalid username or password.';
        } else {
            $error = 'Username and password are required.';
        }
        $this->render('auth.login', ['message' => $error]);
    }

    public function logout() {
        $session = $this->session();
        $session->destroy($session->id());
        $this->render('auth.logout', []);
    }
}
