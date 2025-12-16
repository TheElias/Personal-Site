<?php

use Site\Config;

// Load configuration from .env
$envPath = realpath(__DIR__ . '/../../ignoredFiles/.env');
require __DIR__ . '/../../vendor/autoload.php'; 

if (!$envPath) {
    $envPath = realpath(__DIR__ . '/../../../../config/config.env');
}

Config::load($envPath);

// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
