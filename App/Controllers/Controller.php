<?php

namespace App\Controllers;

abstract class Controller {

    protected static function render($view, $params = []) {
        render_layout($view, $params);
    }

    protected static function currentUser() {
        return \Flight::session()->get('user_id') ?? null;
    }

    protected static function requireAuth() {
        if (empty(\Flight::session()->get('user_id'))) {
            \Flight::redirect('/login');
            exit;
        }
    }
}
