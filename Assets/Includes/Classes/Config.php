<?php

namespace Site;

class Config {
    private static array $values = [];
    private static bool $loaded = false;

    public static function load(string $envPath): void {
        if (self::$loaded) {
            return;
        }

        if (is_readable($envPath)) {
            $content = file_get_contents($envPath);
            self::$values = self::parseEnvFileContents($content);
        }

        self::$loaded = true;
    }

    public static function get(string $key, $default = null) {
        if (!self::$loaded) {
            // Auto-load from default locations if not explicitly loaded
            $locations = [
                __DIR__ . '/../../ignoredFiles/.env',
                '/var/www/config/config.env',
            ];
            foreach ($locations as $path) {
                if (is_readable($path)) {
                    self::load($path);
                    break;
                }
            }
        }

        return self::$values[$key] ?? $default;
    }

    /**
     * PHP 7.4-safe .env parser:
     * - lines like KEY=VALUE
     * - ignores blank lines and comments starting with #
     */
    private static function parseEnvFileContents(string $content): array {
        $values = [];

        $lines = preg_split('/\r\n|\r|\n/', $content);
        foreach ($lines as $line) {
            $line = trim($line);

            // skip empty lines
            if ($line === '') {
                continue;
            }

            // skip comments starting with "#"
            if (substr($line, 0, 1) === '#') {
                continue;
            }

            // must contain "="
            if (strpos($line, '=') === false) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);
            // strip surrounding quotes if present
            $value = trim($value, "\"'");

            if ($key !== '') {
                $values[$key] = $value;
            }
        }

        return $values;
    }
}
