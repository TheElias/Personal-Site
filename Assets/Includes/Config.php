<?php

class Config {
    private static array $values = [];
    private static bool $loaded = false;

    public static function load(string $envPath): void {
        if (self::$loaded) {
            return;
        }

        if (file_exists($envPath)) {
            $content = file_get_contents($envPath);
            self::$values = parse_env_file_contents_to_array($content);
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
                if (file_exists($path)) {
                    self::load($path);
                    break;
                }
            }
        }

        return self::$values[$key] ?? $default;
    }
}