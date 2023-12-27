<?php

        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/Interfaces/iUser.php';
        require_once './Assets/Includes/Classes/UserLogin.php';

    class User extends UserLogin implements iUser 
    {
        protected $database;
        protected $conn;
        protected $id;
        protected $firstName;
        protected $lastName;
        protected $dateOfBirth;
        protected $dateJoined;

        protected $username;
        protected $password;

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn = $this->database->getConnection();
        }

        public function loadUserByID($id)
        {
            $sql = "SELECT *
            FROM personal_website.user 
            WHERE id =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$id]);
            $userInfo = $result -> fetch();  
            
            if (!$userInfo) {
                return false;
            }
            
            $this->id = $id;
            $this->firstName = $userInfo['first_name'];
            $this->lastName = $userInfo['last_name'];
            $this->dateOfBirth = $userInfo['date_of_birth'];
            $this->dateJoined = $userInfo['date_joined'];

            $this->username = $userInfo['username'];
            $this->password = $userInfo['password'];
            

            return true;
        }

        public function loadUserByUsername($username)
        {
            $sql = "SELECT *
            FROM personal_website.user 
            WHERE username =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$username]);
            $userInfo = $result -> fetch();  
            
            if (!$userInfo) {
                return false;
            }
            
            $this->id = $userInfo['id'];
            $this->firstName = $userInfo['first_name'];
            $this->lastName = $userInfo['last_name'];
            $this->dateOfBirth = $userInfo['date_of_birth'];
            $this->dateJoined = $userInfo['date_joined'];

            $this->username = $username;
            $this->password = $userInfo['password'];

            return true;
        }

        private function loadUserBySession()
        {

        }

        public function getID()
        {
            if (empty($this->id))
            {
                return false;
            }
            return $this->id; 
        }

        public function getFirstName()
        {
            if (empty($this->firstName))
            {
                return false;
            }
            return $this->firstName; 
        }

        public function getLastName()
        {
            if (empty($this->lastName))
            {
                return false;
            }
            return $this->lastName; 
        }

        public function getFullName()
        {
            if (empty($this->firstName) || empty($this->lastName))
            {
                return false;
            }
            return $this->firstName . ' ' . $this->lastName; 
        }

        public function getDateOfBirth()
        {
            if (empty($this->dateOfBirth))
            {
                return false;
            }
            return $this->dateOfBirth; 
        }

        public function getJoinedDate()
        {
            if (empty($this->dateJoined))
            {
                return false;
            }
            return $this->dateJoined; 
        }

        
        public function getUsername()
        {
            if (empty($this->username))
            {
                return false;
            }
            return $this->username; 
        }

        
        public function getPassword()
        {
            if (empty($this->password))
            {
                return false;
            }
            return $this->password; 
        }
        

        public static function doesUserExistByID($id)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT * 
            FROM personal_website.user 
            WHERE id =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$id]);
            $userInfo = $result -> fetch();  
            
            if (!$userInfo) {
                return false;
            }
            return true;
        }
    
        public static function getUsersBlogPosts($id)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostTitle, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, U.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id, urlName
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.user AS U ON BPA.blog_post_author_id = U.id
            WHERE A.id =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$id]);
            $userInfo = $result -> fetch();  
            
            if (!$userInfo) {
                return false;
            }
            return $userInfo;
        }

        public static function checkCredentials()
        {
            return false;
        }

    }
?>