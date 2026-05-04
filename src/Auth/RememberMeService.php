<?php

Namespace Site\Auth;

use Site\User\UserTokenDAO;
use SIte\Config\Config;

// Handle "Remember Me" functionality, such as setting and validating cookies

Class RememberMeService {

    private UserTokenDAO $userTokenDAO;

    public function __construct(UserTokenDAO $userTokenDAO) {
        $this->userTokenDAO = $userTokenDAO;
    }

    public function loginFromRememberMeCookie(): bool
    {
        if (isset($_COOKIE['remember_me_token'])) {
            $token = $_COOKIE['remember_me_token'];

            // Here you would normally check the token against a database
            // For demonstration purposes, we'll just check against a hardcoded value

            if (empty($_COOKIE['user_id']) || empty($_COOKIE['user_level'])) {
                return false;
            }   

            $token = $this->userTokenDAO->getTokenByUserid($_COOKIE['user_id']);

            


            if ($token === 'valid_token') {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }
                $_SESSION['user_id'] = $_COOKIE['user_id'];
                $_SESSION['user_level'] = $_COOKIE['user_level']; // Example user level

                return true;
            }
        }

        return false;
    }

    public function setRememberMeToken(int $userId): void
    {
        $selector = bin2hex(random_bytes(32));
        $validator = bin2hex(random_bytes(32));

        $selectorHash = hash('sha256', $selector);
        $validatorHash = password_hash($validator, PASSWORD_DEFAULT);

        $expiresAt = new \DateTime('+30 days');

        $this->userTokenDAO->createToken($userId, $validatorHash, $selectorHash, $expiresAt);

        setcookie(
            'remember_me_token',
            $selector . ':' . $validator,
            $this->getCookieOptions($expiresAt->getTimestamp())
        );
    }

    public function clearByUserId(int $userId): void
    {
        setcookie(
            'remember_me_token',
            '',
            $this->getCookieOptions(time() - 3600)
        );

        $this->userTokenDAO->deleteTokensByUserId($userId);
    }

    private function getCookieOptions(int $expires): array
    {

    return [
        'expires' => $expires,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ];
}
}

?>