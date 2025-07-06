<?php

class Env
{
    public static function load($path = __DIR__ . '/../../.env')
    {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comment lines
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Remove quotes if exist
            $value = trim($value, "\"'");

            // Set to $_ENV
            $_ENV[$key] = $value;
        }
    }
}
