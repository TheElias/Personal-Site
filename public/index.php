<?php

require __DIR__ . '/../init.php';

use Site\Routing\Router;
use Site\Controllers\HomeController;

use Site\Controllers\AdminController;
use Site\Controllers\MediaAdminController;

$adminController = new AdminController($authGuard, $authService);
$mediaAdminController = new MediaAdminController($authGuard, $mediaService);
$homeController = new HomeController();

$route = new Router();

$homeController = new HomeController();

$route->get("/",[$homeController, "index"]);

//$route->get("/blog",$homeController, "blog");

//$route->get("/blog/{urlName}",$homeController, "blogPost");

/*============================
Admin Routes
============================*/

$route->get("/login", [$adminController, 'login']);
$route->post("/login", [$adminController, 'processLogin']);
 
$route->get("/admin", [$adminController, "dashboard"]);
$route->post("/admin", [$adminController, 'update']);

$route->get("/admin/dashboard", [$adminController, 'dashboard']);

$route->get("/admin/media", [$mediaAdminController, 'mediaAdmin']);
$route->get("/admin/mediaAdmin", [$mediaAdminController, 'mediaAdmin']);
$route->post("/admin/Media/upload", [$mediaAdminController, 'mediaUpload']);

$route->notFound("404.php"); 

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if ($uri !== '/') {
    $uri = rtrim($uri, '/');
}

$route->dispatch($_SERVER['REQUEST_METHOD'], $uri);
?> 