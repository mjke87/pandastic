<?php

namespace App\Controllers;

abstract class Controller {

    protected static function render($view, $params = []) {
        render_view($view, $params);
    }

    protected static function currentUser() {
        return $_SESSION['user_id'] ?? null;
    }

    protected static function requireAuth() {
        if (empty($_SESSION['user_id'])) {
            \Flight::redirect('/login');
            exit;
        }
    }
}
