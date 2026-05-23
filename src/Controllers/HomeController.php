<?php

namespace Site\Controllers;

class HomeController
{
    public function index(): void
    {
        require VIEW_PATH . '/home.php';
    }

    public function about(): void
    {
        require VIEW_PATH . '/about.php';
    }
}