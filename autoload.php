<?php

spl_autoload_register(function ($class) {
    if (strpos($class, 'App\\') === 0) {
        $relative = substr($class, 4);
        $relative = str_replace('\\', '/', $relative);
        $file = __DIR__ . '/app/' . $relative . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});
