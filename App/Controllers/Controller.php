<?php

namespace App\Controllers;

abstract class Controller {

    protected function request() {
        return \Flight::request()->data;
    }

    protected function redirect($route, $params = []) {
        $url = url($route, $params);
        \Flight::redirect($url);
        exit;
    }

    protected function render($view, $params = []) {
        render_layout($view, $params);
        exit;
    }

    protected function currentUser() {
        return \Flight::session()->get('user_id') ?? null;
    }

    protected function requireAuth() {
        if (empty(\Flight::session()->get('user_id'))) {
            \Flight::redirect(url('login'));
            exit;
        }
    }

    protected function flash($message, $type = 'info') {
        \Flight::view()->set('flash', (object) [
            'type' => $type,
            'message' => $message
        ]);
    }

    /**
     * @return void
     */
    protected function error($title = 'Error', $message = 'An unexpected error occurred') {
        $this->render('error', [
            'title' => $title,
            'message' => $message
        ]);
    }

    protected function session() {
        return \Flight::session();
    }
}
