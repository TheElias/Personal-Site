<?php

Namespace Site\User;

use DateTime;
use PDO;

class UserTokenDAO {

    protected $database;
    protected $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function createToken(int $userId, string $token, string $selector, DateTime $expiresAt): void
    {
        $sql = "INSERT INTO personal_website.user_tokens (user_id, token, selector, expires_at) VALUES (?, ?, ?, ?)";
        $result = $this->conn->prepare($sql);
        $result->execute([$userId, $token, $selector, $expiresAt->format('Y-m-d H:i:s')]);
    }

    public function getUserIdByToken(string $token): ?int
    {
        $sql = "SELECT user_id FROM personal_website.user_tokens WHERE token = ? AND expires_at > NOW()";
        $result = $this->conn->prepare($sql);
        $result->execute([$token]);
        $info = $result->fetch();

        if (!$info) {
            return null;
        }

        return (int) $info['user_id'];
    }

    public function getTokenByUserid(int $userId, int $expired = 0)
    {
        $sql = "SELECT *
        FROM personal_website.user_token AS UT
        WHERE UT.user_id =  ? AND is_expired = ?";

        $result = $this->conn->prepare($sql);
        $result->execute([$userId, $expired]);
        $tokenInfo = $result -> fetch();  

        return $tokenInfo;
    }    

    public function deleteToken(string $token): void
    {
        $sql = "DELETE FROM personal_website.user_tokens WHERE token = ?";
        $result = $this->conn->prepare($sql);
        $result->execute([$token]);
    }

    public function deleteTokensByUserId(int $userId): void
    {
        $sql = "DELETE FROM personal_website.user_tokens WHERE user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->execute([$userId]);
    }
    
    public function insertToken(string $userId , string $random_password_hash, string $random_selector_hash, string $tokenExpirationDate): bool
    {
        $sql = "INSERT INTO  personal_website.user_token (user_id, password_hash, selector_hash, expiry_date) values (?, ?, ?, ?)";

        $result = $this->conn->prepare($sql);

        $result->execute([$userId, $random_password_hash, $random_selector_hash, $tokenExpirationDate]);

        if ($result->rowCount() >0)
        {
            return true;
        }
        return false;
    }

    public function markTokenAsExpired(int $tokenID) : bool
    {
        $sql = "UPDATE personal_website.user_token SET is_expired = 1 WHERE id = ?";

        $result = $this->conn->prepare($sql);

        $result->execute([$tokenID]);

        if ($result->rowCount() >0)
        {
            return true;
        }
        return false;
    }
    
    public function getTokenbBySelector(string $selectorHash): ?array
    {
        $sql = "SELECT * FROM personal_website.user_token WHERE selector_hash = ? AND expires_at > NOW() LIMIT 1";
        $result = $this->conn->prepare($sql);
        $result->execute([$selectorHash]);
        $tokenInfo = $result->fetch();

        return $tokenInfo ?: null;
    }

}