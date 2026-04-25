<?php

    namespace Site\Interfaces;
    use PDO;
    
interface iTokenAuth {

    public static function getUserByUsername(PDO $conn, $username);
    public static function getTokenByUsername($username,$expired=0);

    public static function markTokenAsExpired($tokenID);
    public static function insertToken($username, $random_password_hash, $random_selector_hash, $tokenExpirationDate);

}

?>