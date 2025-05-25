<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public static function index() {
        $users = User::all();
        self::render('user.list', ['users' => $users]);
    }

    public static function createForm() {
        self::render('user.edit', ['user' => null]);
    }

    public static function create() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $birthday = $_POST['birthday'] ?? '';
        $multiplier = floatval($_POST['multiplier'] ?? 1);
        $current_funds = floatval($_POST['current_funds'] ?? 0);
        if ($username && $password && $name) {
            User::add([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'name' => $name,
                'birthday' => $birthday,
                'multiplier' => $multiplier,
                'current_funds' => $current_funds
            ]);
            \Flight::redirect('/users');
        } else {
            self::render('user.edit', [
                'user' => null,
                'message' => 'Username, password, and name are required.'
            ]);
        }
    }

    public static function editForm($id) {
        $user = User::get($id);
        self::render('user.edit', ['user' => $user]);
    }

    public static function edit($id) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $birthday = $_POST['birthday'] ?? '';
        $multiplier = floatval($_POST['multiplier'] ?? 1);
        $current_funds = floatval($_POST['current_funds'] ?? 0);
        $updateData = [
            'username' => $username,
            'name' => $name,
            'birthday' => $birthday,
            'multiplier' => $multiplier,
            'current_funds' => $current_funds
        ];
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        if ($username && $name) {
            User::update($id, $updateData);
            \Flight::redirect('/users');
        } else {
            self::render('user.edit', [
                'user' => array_merge(User::get($id) ?? [], $_POST),
                'message' => 'Username and name are required.'
            ]);
        }
    }

    public static function delete($id) {
        User::delete($id);
        \Flight::redirect('/users');
    }

    public static function view($id) {
        $user = User::get($id);
        self::render('user.detail', ['user' => $user]);
    }
}
