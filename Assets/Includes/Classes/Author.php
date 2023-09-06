<?php
        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/Interfaces/iAuthor.php';

    class Author implements iAuthor 
    {
        protected $database;
        protected $conn;
        protected $id;
        protected $firstName;
        protected $lastName;
        protected $username;
        protected $dateOfBirth;
        protected $dateJoined;

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn->getConnection();
        }

        
        public function loadAuthorByID($id)
        {
            $sql = "SELECT `id`,
            `first_name`,
            `last_name`,
            `username`,
            `date_of_birth`,
            `date_joined`
            FROM personal_website.author 
            WHERE id =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($id);
            $authorInfo = $result -> fetch();  
            
            if (!$authorInfo) {
                return false;
            }
            
            $this->id = $id;
            $this->firstName = $authorInfo['first_name'];
            $this->lastName = $authorInfo['last_name'];
            $this->username = $authorInfo['username'];
            $this->dateOfBirth = $authorInfo['date_of_birth'];
            $this->dateJoined = $authorInfo['date_joined'];

            return true;
        }

        public function loadAuthorByUsername($username)
        {
            $sql = "SELECT `id`,
            `first_name`,
            `last_name`,
            `username`,
            `date_of_birth`,
            `date_joined`
            FROM personal_website.author 
            WHERE username =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($username);
            $authorInfo = $result -> fetch();  
            
            if (!$authorInfo) {
                return false;
            }
            
            $this->id = $authorInfo['id'];
            $this->firstName = $authorInfo['first_name'];
            $this->lastName = $authorInfo['last_name'];
            $this->username = $username;
            $this->dateOfBirth = $authorInfo['date_of_birth'];
            $this->dateJoined = $authorInfo['date_joined'];

            return true;
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
        public function getUsername()
        {
            if (empty($this->username))
            {
                return false;
            }
            return $this->username; 
        }

        public function getDateOfBirth()
        {
            if (empty($this->dateOfBirth))
            {
                return false;
            }
            return $this->dateOfBirth; 
        }

        public static function doesAuthorExist($id)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT `id`,
            `first_name`,
            `last_name`,
            `username`,
            `date_of_birth`,
            `date_joined`
            FROM personal_website.author 
            WHERE id =  ?";

            $result = $conn->prepare($sql);
            $result->execute($id);
            $authorInfo = $result -> fetch();  
            
            if (!$authorInfo) {
                return false;
            }
            return true;
        }
    
        public static function getAuthorsBlogPosts($id)
        {

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostTitle, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id, urlName
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE A.id =  ?";

            $result = $conn->prepare($sql);
            $result->execute($id);
            $authorInfo = $result -> fetch();  
            
            if (!$authorInfo) {
                return false;
            }
            return $authorInfo;
        }
    }
?>