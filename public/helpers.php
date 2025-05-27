<?php

/**
 * Load config value from config folder using dot notation.
 *
 * @param string $key Dot notation key, e.g. 'app.name'
 * @return mixed|null The config value or null if not found
 */
function config($key) {
    static $configs = [];

    $parts = explode('.', $key);
    $file = array_shift($parts);

    // Only load once per file
    if (!isset($configs[$file])) {
        $path = APP_ROOT . '/config/' . $file . '.php';
        if (file_exists($path)) {
            $configs[$file] = require $path;
        } else {
            $configs[$file] = [];
        }
    }

    $value = $configs[$file];
    foreach ($parts as $part) {
        if (is_array($value) && array_key_exists($part, $value)) {
            $value = $value[$part];
        } else {
            return null;
        }
    }
    return $value;
}

/**
 * Render a view file with parameters.
 * This function uses Flight's render method to include the view file
 * and pass parameters to it. The view file should be in the views directory
 * and follow the dot notation convention for paths (e.g., 'folder.view').
 *
 * @param string $view The view file path in dot notation
 * @param array $params Parameters to pass to the view
 * @param string|null $key Optional key to assign the rendered output
 * @return void
 */
function render_view($view, $params = [], $key = null) {
    $path = str_replace('.', '/', $view) . '.php';
    Flight::render($path, $params, $key);
}

/**
 * Render a view with layout and CSS framework.
 *
 * @param string $view The view name in dot notation
 * @param array $params Parameters to pass to the view
 * @return void
 */
function render_layout($view, $params = [], $layout = 'layout') {
    render_view($view, $params, 'content');
    render_view($layout, [
        'title' => config('app.app_name'),
        'css_framework' => [
            'https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.cyan.min.css',
            //'https://cdn.jsdelivr.net/npm/@tabler/core@1.3.2/dist/css/tabler.min.css',
        ],
        'js_framework' => [
            'https://cdn.jsdelivr.net/npm/@picocss/pico@2/js/pico.min.js',
            //'https://cdn.jsdelivr.net/npm/@tabler/core@1.3.2/dist/js/tabler.min.js',
        ],
        'theme' => Flight::get('theme') ?? 'light',
    ]);
}

/**
 * Get the current user.
 *
 * @return \App\Models\User|null The current user or null if not logged in
 */
function current_user() {
    return (object) \Flight::get('user') ?: [];
}

/**
 * Check if the current user has a given permission.
 *
 * @param string $cap The capability to check
 * @return bool True if the user has the capability, false otherwise
 */
function user_can($cap) {
    $permission = Flight::get('permission');
    if (!$permission) {
        return false;
    }
    return $permission->has($cap);
}

/**
 * Format a date string according to a given format.
 *
 * @param string $date Date string in 'Y-m-d' or 'Y-m-d H:i:s'
 * @param string|null $format Optional format string, defaults to config date format
 * @return string
 */
function format_date($date, $format = null) {
    if (!$date) return '';
    $dt = \DateTime::createFromFormat('Y-m-d', substr($date, 0, 10));
    if (!$dt) return htmlspecialchars($date);
    $format = $format ?: config('app.date_format') ?: 'd.m.Y';
    return $dt->format($format);
}

/**
 * Check if the given route matches the current URL.
 * By default, it checks for an exact match.
 * If you set fuzzy mode, it checks if the current URL starts with the given route.
 *
 * @param string $route The URL or path to check (e.g., '/grades')
 * @param string $fuzzy Whether to use fuzzy matching (default false)
 * @return bool
 */
function is_route($route, $fuzzy = false) {
    $current = Flight::request()->url;
    if (!$fuzzy) {
        return rtrim($current, '/') === rtrim($route, '/');
    }
    // fuzzy match if current URL starts with the route
    return strpos(rtrim($current, '/'), rtrim($route, '/')) === 0;
}
