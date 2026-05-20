<?php

require __DIR__ . '/../init.php';

use Site\Routing\Router;

use Site\Controllers\AdminController;
use Site\Controllers\HomeController;

$adminController = new AdminController($authGuard);
$homecontroller = new HomeController();

$route = new Router();

$homeController = new HomeController();

$route->get("/",[$homeController, "index"]);

//$route->get("/blog",$homeController, "blog");

//$route->get("/blog/{urlName}",$homeController, "blogPost");
 
$route->get("/admin", [$adminController, "dashboard"]);
$route->post("/admin", [$adminController, 'update']);

$route->get("/admin/manager", [$adminController, 'manager']);
$route->post("/admin/manager", [$adminController, 'updateManager']);
    
$route->get("/admin/dashboard", [$adminController, 'dashboard']);

$route->notFound("404.php"); 

?>