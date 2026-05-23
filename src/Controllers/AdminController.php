<?php

namespace Site\Controllers;

use Site\Auth\AuthGuard;

class AdminController
{
    public function __construct(
        private AuthGuard $authGuard
    ) {}

    public function dashboard(): void
    {
        $this->authGuard->requireLogin();

        require VIEW_PATH . '/admin/adminDashboard.php';
    }

    public function images(): void
    {
        $this->authGuard->requireLogin();

        require VIEW_PATH . '/admin/imageAdmin.php';
    }

    public function imageUpload(): void
    {
        $this->authGuard->requireLogin();

        require VIEW_PATH . '/admin/imageUpload.php';
    }

    public function posts(): void
    {
        $this->authGuard->requireLogin();

        require VIEW_PATH . '/admin/posts.php';
    }

    public function settings(): void
    {
        $this->authGuard->requireLevel(LEVEL_ADMIN);

        require VIEW_PATH . '/admin/settings.php';
    }

    public function login(): void
    {
        require VIEW_PATH . '/admin/login.php';
    }
}