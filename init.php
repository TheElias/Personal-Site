<?php

use Site\Config\Config;

// Setup environment globals that are used often
define('PROJECT_ROOT', __DIR__);
define('TEMPLATE_PATH', PROJECT_ROOT . '/templates');

// Load configuration from .env
$envPath = realpath(PROJECT_ROOT . '/../../ignoredFiles/.env');



require PROJECT_ROOT . '/vendor/autoload.php'; 

if (!$envPath) {
    $envPath = realpath(PROJECT_ROOT . 'src/Config/config.env');
}

Config::load($envPath);

// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
