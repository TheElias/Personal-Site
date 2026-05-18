<?php 

Namespace Site\Auth;

use Site\User\UserDAO;
use Site\Auth\RememberMeService;

// Handles Identity Verify Password, Set Session, Handle Remember Me, etc.

Class AuthService {

    public function __construct(
        private UserDAO $userDAO,
        private RememberMeService $rememberMeService
    ) {}
    public function login(string $username, string $password, bool $rememberMe = false): bool
    {
        // Here you would normally check the username and password against a database
        // For demonstration purposes, we'll just check against hardcoded values

        $user = $this->userDAO->getUserByUsername($username);

        if (!$user) {
            return false;
        }

       if (!password_verify($password, $user->getPasswordHash())) {
            return false;
        }
        
        $this->createSessionForUser($user->getId(), $user->getUsername(), $user->getUserLevel());
    
        if ($rememberMe) {
            $this->rememberMeService->setRememberMeToken($user->getId());
        }

        return true;
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Clear remember me cookie
        $this->rememberMeService->clearByUserId($_SESSION['user_id']);

        // Clear session data
        $_SESSION = [];

        session_destroy();
    }

    public function createSessionForUser(int $userId, string $username, int $userLevel): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_level'] = $userLevel;
        $_SESSION['username'] = $username;
    }

    public function isAuthenticated(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return isset($_SESSION['user_id']);
    }

    public function isLoggedIn(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!empty($_SESSION['username'])) {
            return true;
        }

        if ($this->rememberMeService->loginFromRememberMeCookie()) {
            return true;
        }

        return false;
    }

    // Other authentication-related functions

}
?>