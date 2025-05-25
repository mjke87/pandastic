<?php

namespace App\Middlewares;

class AuthGate {

    /**
     * Middleware to check user permissions before accessing a route.
     *
     * This middleware checks if the user has the required permission
     * to access the route based on the @permission annotation in the
     * controller method's docblock.
     */
    public function before($params) {
        $permission = \Flight::get('permission');
        if (!$permission) return;
        $route = \Flight::router()->current();
        if (!$route) return;
        $callback = $route->callback;
        // Only handle [ClassName, method] style callbacks
        if (is_array($callback) && count($callback) === 2 && is_string($callback[0]) && is_string($callback[1])) {
            $ref = new \ReflectionMethod($callback[0], $callback[1]);
            $doc = $ref->getDocComment();
            if ($doc && preg_match('/@permission\s+(.+)/', $doc, $m)) {
                $cap = $m[1];
                if (!$permission->has($cap)) {
                    render_layout('error', [
                        'title' => 'Permission Denied',
                        'message' => sprintf('You are not allowed to %s.', $cap)]);
                    exit;
                }
            }
        }
    }

    /**
     * This method is called after the request is handled.
     * It can be used for any post-processing, but in this case,
     * we don't need to do anything.
     *
     * @param array $params Parameters passed to the middleware
     */
    public function after($params) {
        // nothing to do here
        // This method can be used for post-processing after the request is handled
    }
}