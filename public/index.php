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
$route->get("/admin/Media/upload", [$mediaAdminController, 'mediaUpload']);
$route->post("/admin/Media/upload", [$mediaAdminController, 'mediaUploadPost']);

$route->notFound("404.php"); 

?>