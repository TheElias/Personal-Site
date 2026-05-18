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
        if(!empty($_SESSION['user_id'])) {
            return true;
        }

        if(empty($_COOKIE['remember_me_token'])) {
            return false;
        }

        $cookieParts = explode(':', $_COOKIE['remember_me_token'], 2);

        if (count($cookieParts) !== 2) {
            return false;
        }

        [$selector, $validator] = $cookieParts;

        $selectorHash = hash('sha256', $selector);

        $tokenInfo = $this->userTokenDAO->getTokenBySelector($selectorHash);

        if (!$tokenInfo) {
            $this->clearCookie();
            return false;
        }

        if (!password_verify($validator, $tokenInfo['token'])) {
            $this->clearCookie();
            return false;
        }

        return true;
    }

    public function setRememberMeToken(int $userId): void
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        $selectorHash = hash('sha256', $selector);
        $validatorHash = password_hash($validator, PASSWORD_DEFAULT);

        $expiresAt = new \DateTime('+30 days');

        $this->userTokenDAO->createToken($userId, $selectorHash, $validatorHash, $expiresAt);

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

    private function clearCookie(): void
{
    setcookie(
        'remember_me_token',
        '',
        $this->getCookieOptions(time() - 3600)
    );
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