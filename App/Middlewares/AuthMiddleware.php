<?php

namespace App\Middlewares;


class AuthMiddleware
{
    public static function handle()
    {
        $publicRoutes = [
            '/login', '/logout', '/public', '/public/', '/public/index.php'
        ];
        $requestUri = strtok($_SERVER['REQUEST_URI'], '?');
        $isPublic = false;
        foreach ($publicRoutes as $route) {
            if ($requestUri === $route || strpos($requestUri, $route) === 0) {
                $isPublic = true;
                break;
            }
        }

        if (
            $isPublic ||
            strpos($requestUri, '/public/') === 0 ||
            strpos($requestUri, '/login') === 0 ||
            strpos($requestUri, '/logout') === 0
        ) {
            return;
        }
        // If not logged in, redirect to login
        if (empty(\Flight::session()->get('user_id'))) {
            \Flight::redirect('/login');
            exit;
        }
    }
}
