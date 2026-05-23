<?php
declare(strict_types=1);

// Setup environment globals that are used often
define('PROJECT_ROOT', __DIR__);

define('TEMPLATE_PATH', PROJECT_ROOT . '/templates');
define('VIEW_PATH', PROJECT_ROOT . '/views');
define('PUBLIC_PATH', PROJECT_ROOT . '/public');
define('CONFIG_PATH', PROJECT_ROOT . '/src/config');

define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('ASSETS_URL', '/assets');
define('MAIN_CSS_PATH', '/CSS/mainStyle.css');
define('ADMIN_CSS_PATH', '/CSS/adminStyle.css');
define('MAIN_JS_PATH', '/JS/mainScript.js');

define('MAIN_HEADER_PATH', TEMPLATE_PATH . '/partials/header.php');
define('MAIN_FOOTER_PATH', TEMPLATE_PATH . '/partials/footer.php');

define('MAIN_ADMIN_HEADER_PATH', TEMPLATE_PATH . '/partials/adminHeader.php');
define('MAIN_ADMIN_FOOTER_PATH', TEMPLATE_PATH . '/partials/adminFooter.php');

const LEVEL_PENDING 	= 0; //User is still pending email confirmation
const LEVEL_USER 		= 1; //Standard user with normal privileges
const LEVEL_AUTHOR 		= 2; //Standard user with author privileges
const LEVEL_MODERATOR 	= 3; //Special case users with higher privileges
const LEVEL_ADMIN 		= 4; //Administrators with all privileges

require PROJECT_ROOT . '/vendor/autoload.php'; 

use Site\Config\Config;
use Site\Database\Database;
use Site\Auth\AuthService;
use Site\Auth\AuthGuard;
use Site\Auth\RememberMeService;
use Site\User\UserDAO;
use Site\User\UserTokenDAO;
use Site\Controllers\AdminController;

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
$authGuard = new AuthGuard($authService);


// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
