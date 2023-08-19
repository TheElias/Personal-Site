<?php
        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/Interfaces/iBlogPostTag.php';

    class BlogPostTag implements iBlogPostTag
    {
        protected $database;
        protected $conn;
        protected $tagID;
        protected $tagName;

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn = $this->database->getConnection();
        }

        public function loadTagByID($id)
        {
            
            $sql = "SELECT * FROM personal_website.tag 
                    WHERE id =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$id]);
            $tagInfo = $result -> fetch();  
            
            if (!$tagInfo) {
                return false;
            }
            
            $this->tagID = $tagInfo['id'];
            $this->tagName = $tagInfo['name'];

            return true;
        }

        public function loadTagByName($name)
        {
            $sql = "SELECT * FROM personal_website.tag 
                    WHERE name =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$name]);
            $tagInfo = $result -> fetch();  
            
            if (!$tagInfo) {
                return false;
            }
            
            $this->tagID = $tagInfo['id'];
            $this->tagName = $tagInfo['name'];

            return true;
        }

        public function getID()
        {
            if(empty($this->tagID))
            {
                return false;
            }

            return $this->tagID;
        }

        public function getName()
        {
            if(empty($this->tagName))
            {
                return false;
            }

            return $this->tagName;
        }
    
        public function save()
        {
            if(empty($this->tagID) or empty($this->tagName))
            {
                return false;
            }

            $sql = "UPDATE personal_website.tag (tagName)
            SET tagName = ?
            WHERE ID =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$this->tagName,$this->tagID]);
            
            return true;
        }

        public static function saveNewTag($name)
        {
            if (BlogPostTag::doesTagExistByName($name))
            {
                return true;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "INSERT INTO personal_website.tag ('name') VALUES (?)";

            $result = $conn->prepare($sql);

            if (!$result)
            {
                return false;
            }

            $result->execute($name);

            return true;
        }

        public static function doesTagExistByName($name)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            $sql = "SELECT * FROM personal_website.tag 
            WHERE name =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$name]);
            $tagInfo = $result -> fetch();  

            if (!$tagInfo) {
                return false;
            }

            return true;
        }

        public static function doesTagExistByID($ID)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            $sql = "SELECT * FROM personal_website.tag 
            WHERE ID =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$ID]);
            $tagInfo = $result -> fetch();  

            if (!$tagInfo) {
                return false;
            }

            return true;
        }

        public static function fetchBlogPostsRelatedToTagByID($tagID)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            $sql = "SELECT BP.ID
                    FROM personal_website.blog_post AS BP
                    INNER JOIN personal_website.blog_post_tag AS BPT ON BPT.blog_post_id = BP.id
                    INNER JOIN personal_website.tag AS T ON T.id = BPT.tag_id 
                    WHERE T.id =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$tagID]);
            $tagInfo = $result -> fetch();  
            
            if (!$tagInfo) {
                return false;
            }
            
            return $tagInfo;
        }

        public static function fetchBlogPostsRelatedToTagByName($name)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            $sql = "SELECT BP.ID
                    FROM personal_website.blog_post AS BP
                    INNER JOIN personal_website.blog_post_tag AS BPT ON BPT.blog_post_id = BP.id
                    INNER JOIN personal_website.tag AS T ON T.id = BPT.tag_id 
                    WHERE T.name =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$name]);
            $tagInfo = $result -> fetch();  
            
            if (!$tagInfo) {
                return false;
            }
            
            return $tagInfo;
        }
    }
?>