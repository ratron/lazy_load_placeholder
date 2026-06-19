<?php

if (!class_exists(\ColorThief\ColorThief::class, false)) {
    spl_autoload_register(static function (string $class): void {
        $prefix = 'ColorThief\\';

        if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
            return;
        }

        $relativeClass = substr($class, strlen($prefix));
        $file = __DIR__ . '/src/ColorThief/' . str_replace('\\', '/', $relativeClass) . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    });
}
