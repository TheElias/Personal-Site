<?php

require_once __DIR__ . '/generalFunctions.php';
require_once __DIR__ . '/Config.php';

// Load configuration from .env
$envPath = realpath(__DIR__ . '/../../ignoredFiles/.env');
if (!$envPath) {
    $envPath = '/var/www/config/config.env';
}
Config::load($envPath);

// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
