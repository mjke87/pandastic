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
    // Pass Flight variables to the view
    \Flight::get('user', current_user());
    render_view($view, $params, 'content');
    render_view($layout, [
        'title' => config('app.app_name'),
        'css_framework' => [
            'https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.green.min.css',
            asset_url('css/style.css'),
        ],
        'js_framework' => [
            'https://cdn.jsdelivr.net/npm/@picocss/pico@2/js/pico.min.js',
            asset_url('js/app.js'),
        ],
        'theme' => Flight::get('theme') ?? 'light',
    ]);
}

/**
 * Get the URL for an asset in the public directory.
 *
 * @param string $path Path relative to the public directory (e.g. 'img/logo.png')
 * @return string
 */
function asset_url($path) {
    $path = ltrim($path, '/');
    $public_dir = config('app.public_dir') ?: APP_ROOT . '/public';
    $public_url =  str_replace(APP_ROOT, '', rtrim(str_replace('\\', '/', $public_dir), '/') . '/');
    return htmlspecialchars($public_url . $path);
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

/**
 * Get the URL for a named route.
 * This function uses Flight's getUrl method to generate a URL
 * based on the route name and optional parameters.
 * You may pass a model instance as $params, in which case ['id' => $model->id] will be used.
 *
 * @param string $name The name of the route
 * @param array|object $params Optional parameters or model instance
 * @return string The generated URL
 */
function url($name, $params = []) {
    if (is_object($params) && isset($params->id)) {
        $params = ['id' => $params->id];
    }
    return Flight::getUrl($name, $params);
}

/**
 * Generate an icon HTML element or inline SVG.
 * If $inline is true, attempts to inline the SVG file contents.
 * Otherwise, creates an <img> tag for the icon image.
 * The image should be located in the public/icons directory.
 *
 * @param string $name The name of the icon file (without extension)
 * @param bool $inline Whether to inline the SVG (default false)
 * @return string HTML <img> tag or inline SVG
 */
function icon($name, $inline = true) {
    $path = "icons/$name.svg";
    $fullPath = config('app.public_dir') . "/$path";
    if (!file_exists($fullPath)) {
        return '';
    }
    if ($inline) {
        return preg_replace('/<svg\b([^>]*)>/', '<svg$1 class="icon">', file_get_contents($fullPath), 1);
    }
    return '<img src="' . asset_url($path) . '" alt="' . htmlspecialchars(ucfirst($name) . ' Logo') . '" class="icon">';
}

/**
 * Pluralize a word (basic English rules).
 *
 * @param string $word
 * @return string
 */
function pluralize($word) {
    // Words ending in s, x, z, ch, sh: add "es"
    if (preg_match('/(s|x|z|ch|sh)$/i', $word)) {
        return $word . 'es';
    }
    // Words ending in y preceded by a consonant: replace y with ies
    if (preg_match('/[^aeiou]y$/i', $word)) {
        return substr($word, 0, -1) . 'ies';
    }
    // Default: just add "s"
    return $word . 's';
}

/**
 * Translate a string (stub).
 *
 * @param string $text The text to translate
 * @param array $params Optional parameters for replacement
 * @return string The translated text with parameters replaced
 */
function __($text, $params = []) {
    // Simple replacement, no actual translation backend
    if (!empty($params)) {
        error_log(print_r($params, true));
        foreach ($params as $key => $value) {
            $text = str_replace(':' . $key, $value, $text);
        }
    }
    return $text;
}
