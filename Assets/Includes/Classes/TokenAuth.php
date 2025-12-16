<?php

        namespace Site;

        use Site\Interfaces\iTokenAuth;

    class TokenAuth implements iTokenAuth 
    {
        protected $database;
        protected $conn;

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn = $this->database->getConnection();
        }

        public static function getUserByUsername($username)
        {  

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT *
            FROM personal_website.User AS U
            WHERE U.username =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$username]);
            $userInfo = $result -> fetch();  

            return $userInfo;
        }
        public static function getTokenByUsername($username,$expired = 0)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT *
            FROM personal_website.user_token AS UT
            WHERE UT.username =  ? AND is_expired = ?";

            $result = $conn->prepare($sql);
            $result->execute([$username, $expired]);
            $tokenInfo = $result -> fetch();  

            return $tokenInfo;
        }
    
        public static function markTokenAsExpired($tokenID)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "UPDATE personal_website.user_token SET is_expired = 1 WHERE id = ?";

            $result = $conn->prepare($sql);
            echo "<br /> Token ID: " . $tokenID;
            echo "<br /> UPDATE personal_website.user_token SET is_expired = 1 WHERE id = ?";
            $result->execute([$tokenID]);

            if ($result->rowCount() >0)
            {
                return true;
            }
            return false;
        }

        public static function insertToken($username, $random_password_hash, $random_selector_hash, $tokenExpirationDate)
        {
            echo $username, $random_password_hash,"<br>/" . $random_selector_hash, $tokenExpirationDate;
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "INSERT INTO  personal_website.user_token (username, password_hash, selector_hash, expiry_date) values (?, ?, ?, ?)";

            $result = $conn->prepare($sql);

            $result->execute([$username, $random_password_hash, $random_selector_hash, $tokenExpirationDate]);

            if ($result->rowCount() >0)
            {
                return true;
            }
            return false;
        }



    }
?>