<?php

namespace Site\Controllers;

use Site\Auth\AuthGuard;
use Site\Auth\AuthService;

class AdminController
{
    public function __construct(
        private AuthGuard $authGuard,
        private AuthService $authService
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
        if ($this->authService->isLoggedIn()) {
            header('Location: /admin/dashboard');
            exit;
        }

        require VIEW_PATH . '/admin/login.php';
    }

    public function processLogin(): void
    {
        // Handle login form submission and authentication logic here
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        if ($this->authService->login($username, $password, $remember)) {
            $redirect = $_SESSION['intended_url'] ?? '/admin/dashboard';
            unset($_SESSION['intended_url']);

            header('Location: ' . $redirect);
            exit;
        }

        $message = 'Invalid Login';

        require VIEW_PATH . '/admin/login.php'; 
    }
}