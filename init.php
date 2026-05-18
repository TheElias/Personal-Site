<?php
declare(strict_types=1);

// Setup environment globals that are used often
define('PROJECT_ROOT', __DIR__);
define('TEMPLATE_PATH', PROJECT_ROOT . '/templates');


require PROJECT_ROOT . '/vendor/autoload.php'; 

use Site\Config\Config;
use Site\Database\Database;
use Site\Auth\AuthService;
use Site\Auth\RememberMeService;
use Site\User\UserDAO;
use Site\User\UserTokenDAO;

// Load configuration from .env
$envPath = realpath(PROJECT_ROOT . '/../../ignoredFiles/.env');

if (!$envPath) {    
    $envPath = realpath(PROJECT_ROOT . '/../../config/config.env');
    }

if ($envPath === false) {
    throw new RuntimeException('No environment config file found.' .  (PROJECT_ROOT . '/../../config/config.env'));
}

Config::load($envPath);

$database = Database::fromEnvironment();
$pdo = $database->getConnection();

$userTokenDAO = new UserTokenDAO($pdo);
$rememberMeService = new RememberMeService($userTokenDAO);
$userDAO = new UserDAO($pdo);
$authService = new AuthService($userDAO, $rememberMeService);

// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
