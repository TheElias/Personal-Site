<?php
declare(strict_types=1);

echo "=== getenv() ===", PHP_EOL;
var_dump(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')

);

echo PHP_EOL, "=== \$_ENV ===", PHP_EOL;
var_dump(
    $_ENV['DB_HOST'] ?? null,
    $_ENV['DB_NAME'] ?? null,
    $_ENV['DB_USER'] ?? null,
    $_ENV['DB_PASS'] ?? null,
    $_ENV['DB_PORT'] ?? null
);

echo PHP_EOL, "=== \$_SERVER ===", PHP_EOL;
var_dump(
    $_SERVER['DB_HOST'] ?? null,
    $_SERVER['DB_NAME'] ?? null,
    $_SERVER['DB_USER'] ?? null,
    $_SERVER['DB_PASS'] ?? null,
    $_SERVER['DB_PORT'] ?? null
);

echo PHP_EOL, "=== variables_order ===", PHP_EOL;
echo ini_get('variables_order'), PHP_EOL;
