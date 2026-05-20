<?php

Namespace Site\Auth;

use Site\Auth\AuthService;

Class AuthGuard {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function requireLogin(string $redirectTo = '/manager'): void
    {
        if ($this->authService->isLoggedIn()) {
            return;
        }

        $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];

        header('Location: ' . $redirectTo);
        exit;
    }

    public function requireLevel(int $minimumLevel, string $redirectTo = '/manager'): void
    {
        $this->requireLogin($redirectTo);

        $userLevel = $_SESSION['user_level'] ?? 0;

        if ($userLevel < $minimumLevel) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }


}

?>