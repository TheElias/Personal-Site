<?php

Namespace Site\Auth;

use Site\Auth\AuthService;

// Enforces Rules. Check if user is logged in, Check if user has required level, Redirect to login page if not, etc.

    //The various user levels
    const LEVEL_PENDING 	= 0; //User is still pending email confirmation
    const LEVEL_USER 		= 1; //Standard user with normal privileges
    const LEVEL_AUTHOR 		= 2; //Standard user with author privileges
    const LEVEL_MODERATOR 	= 3; //Special case users with higher privileges
    const LEVEL_ADMIN 		= 4; //Administrators with all privileges

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