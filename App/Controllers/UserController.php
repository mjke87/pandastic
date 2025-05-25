<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Render the index view for users.
     *
     * @return void
     * @permission view users
     */
    public static function index() {
        $users = User::all();
        self::render('user.list', ['users' => $users]);
    }

    /**
     * Show the create user form.
     * @permission create users
     */
    public static function createForm() {
        self::render('user.edit', ['user' => null]);
    }

    /**
     * Handle user creation.
     * @permission create users
     */
    public static function create() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $birthday = $_POST['birthday'] ?? '';
        $multiplier = floatval($_POST['multiplier'] ?? 1);
        $current_funds = floatval($_POST['current_funds'] ?? 0);
        $goal = floatval($_POST['goal'] ?? 100);

        if ($username && $password && $name) {
            User::add([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'name' => $name,
                'birthday' => $birthday,
                'multiplier' => $multiplier,
                'current_funds' => $current_funds,
                'goal' => $goal
            ]);
            \Flight::redirect('/users');
        } else {
            self::render('user.edit', [
                'user' => new User($_POST),
                'error' => 'Username, password, and name are required.'
            ]);
        }
    }

    /**
     * Show the edit user form.
     * @permission edit users
     */
    public static function editForm($id) {
        $user = User::get($id);
        if (!$user) {
            \Flight::redirect('/users');
        }
        self::render('user.edit', ['user' => $user]);
    }

    /**
     * Handle user edit.
     * @permission edit users
     */
    public static function edit($id) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $birthday = $_POST['birthday'] ?? '';
        $multiplier = floatval($_POST['multiplier'] ?? 1);
        $current_funds = floatval($_POST['current_funds'] ?? 0);
        $goal = floatval($_POST['goal'] ?? 100);

        if ($username && $name) {
            $updateData = [
                'username' => $username,
                'name' => $name,
                'birthday' => $birthday,
                'multiplier' => $multiplier,
                'current_funds' => $current_funds,
                'goal' => $goal
            ];
            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            User::update($id, $updateData);
            \Flight::redirect('/users');
        } else {
            $data = array_merge(['id' => $id], $_POST);
            self::render('user.edit', [
                'user' => new User($data),
                'error' => 'Username and name are required.'
            ]);
        }
    }

    /**
     * Delete a user.
     * @permission delete users
     */
    public static function delete($id) {
        User::delete($id);
        \Flight::redirect('/users');
    }

    /**
     * View user details.
     * @permission view users
     */
    public static function view($id) {
        $user = User::get($id);
        if (!$user) {
            \Flight::redirect('/users');
        }
        self::render('user.detail', ['user' => $user]);
    }
}
