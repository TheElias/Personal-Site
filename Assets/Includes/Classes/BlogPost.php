<?php
        include('../Assets/Includes/Classes/Database.php');
        include('../Assets/Includes/Classes/Interfaces/iBlogPost.php');
        include('../Assets/Includes/Classes/BlogPostTag.php');
        include('../Assets/Includes/Classes/Image.php');

    class BlogPost implements iBlogPost
    {
        protected $database;
        protected $conn;
        protected $blogID;
        protected $urlName;
        protected $authorUsername;
        protected $blogText;
        protected $title;
        protected $estimatedReadTime;
        protected $headerImageID;
        protected $dateCreated;
        protected $tags = array();

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn->getConnection();
        }

        public function loadBlogByID($id=1)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id , urlName 
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE BP.id =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($id);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            $this->blogID = $id;
            $this->urlname =$blogPostInfo['urlName'];
            $this->authorUsername = $blogPostInfo['authorUsername'];
            $this->blogText = $blogPostInfo['blogPostText'];
            $this->urlName = $blogPostInfo['urlName'];
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->dateCreated = $blogPostInfo['estimatedReadTime'];
            $this->title = $blogPostInfo['blogPostName'];
            $this->headerImageID = $blogPostInfo['headerID'];

            return true;
        }

        public function loadBlogByURLName($urlName)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id 
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE BP.urlName =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($urlName);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            $this->blogID = $blogPostInfo['blogPostID'];
            $this->urlname = $urlName;
            $this->authorUsername = $blogPostInfo['authorUsername'];
            $this->blogText = $blogPostInfo['blogPostText'];
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->dateCreated = $blogPostInfo['estimatedReadTime'];
            $this->title = $blogPostInfo['blogPostName'];
            $this->headerImageID = $blogPostInfo['headerID'];

            return true;
        }
        public function loadBlogByTitle($blogPostTitle)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostTitle, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id, urlName
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE BP.name =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($blogPostTitle);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            $this->blogID = $blogPostInfo['blogPostID'];
            $this->urlname = $blogPostInfo['blogPostID'];
            $this->authorUsername = $blogPostInfo['authorUsername'];
            $this->blogText = $blogPostInfo['blogPostText'];
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->dateCreated = $blogPostInfo['estimatedReadTime'];
            $this->title = $blogPostTitle;
            $this->headerImageID = $blogPostInfo['headerID'];

            return true;
        }
    
        public function fetchTags($blogID)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostTitle, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id, urlName
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE BP.ID =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($blogID);
            $tags = $result->fetchAll(PDO::FETCH_ASSOC); 

            if (!$tags) {
                return false;
            }

            $this->tags = $tags;

            return true;
        }
        
        public function getID()
        {
            if (empty($this->blogID))
            {
                return false;
            }
            return $this->blogID;
        }
        
        public function getText()
        {
            if (empty($this->blogText))
            {
                return false;
            }
            return $this->blogText; 
        }
        public function getURLName()
        {
            if (empty($this->urlName))
            {
                return false;
            }
            return $this->urlName; 
        }
        public function getAuthorUsername()
        {
            if (empty($this->authorUsername))
            {
                return false;
            }
            return $this->authorUsername; 
        }

        public function getAuthorFullName()
        {
            if (empty($this->authorUsername))
            {
                return false;
            }
            return $this->authorUsername; 
        }


        public function getTitle()
        {
            if (empty($this->title))
            {
                return false;
            }
            return $this->title; 
        }

        public function getTags()
        {
            if (empty($this->tags))
            {
                return false;
            }
            return $this->tags; 
        }

        public function getEstimatedReadTime()
        {
            if (empty($this->estimatedReadTime))
            {
                return false;
            }
            return $this->estimatedReadTime; 
        }

        public function getDateCreated()
        {
            if (empty($this->dateCreated))
            {
                return false;
            }
            return $this->dateCreated; 
        }

        public function getBlogTextSnippet ($length = 250)
        {
            if (empty($this->blogText))
            {
                return false;
            }

            $textSnippet = (strlen($this->blogText)>$length ? substr($this->blogText,0,$length) . "..." : $this->blogText);
            return $textSnippet;
        }

        public function getHeaderImage()
        {
            $myImage = new Image;

            $myImage->loadImageByID($this->headerImageID);

            if (!$myImage) 
            {
                return false;
            }

            return $myImage;
        }
    
        public static function doesBlogPostExistByID($blogID)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT BP.ID
                    FROM personal_website.blog_post AS BP
                    WHERE BP.id =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$blogID]);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            return true;
        }

        public static function doesBlogPostExistByName($name)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT BP.ID
                    FROM personal_website.blog_post AS BP
                    WHERE BP.name =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$name]);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            return true;
        }

        public static function doesBlogPostExistByURLName($URLName)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT BP.ID
                    FROM personal_website.blog_post AS BP
                    WHERE BP.urlName =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$URLName]);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            return true;
        }

        public static function addTagToBlogPost($blogID, $tagName)
        {
            if (!BlogPost::doesBlogPostExistByID($blogID))
            {
                return false;
            }
            
            if (!BlogPostTag::doesTagExistByName($tagName)) 
            {
                return false;
                //BlogPostTag::saveNewTag($tagName);
            }

            $myTag = new BlogPostTag;
            $myTag->loadTagByName($tagName);

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            

            $sql = "INSERT INTO blog_post_tag (blogID, tagID) VALUES (?,?)";

            $result = $conn->prepare($sql);
            $result->execute($blogID,[$myTag->getID()]);
            $tagInfo = $result -> fetch();  

            return true;
        }
    
        public static function insertNewBlogPost($name, $text, $urlName, $header_Image_ID=1)
        {

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            if (BlogPost::doesBlogPostExistByName($name))
            {
                return false;
            }

            if (BlogPost::doesBlogPostExistByURLName($urlName))
            {
                return false;
            }

            $sql = "INSERT INTO blog_post_tag (name, text, urlName, header_image_ID) VALUES (?,?,?,?)";

            $result = $conn->prepare($sql);
            $result->execute($name, $text, $urlName, $header_Image_ID);

            if (!BlogPost::doesBlogPostExistByName($name))
            {
                return false;
            }
            return true;
        }
        public static function updateBlogPost($id, $text, $header_Image_ID=1)
        {   
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            if (!BlogPost::doesBlogPostExistByID($id))
            {
                return false;
            }

            $sql = "UPDATE blog_post_tag (text, header_image_ID) WHERE  id = ?";

            $result = $conn->prepare($sql);
            $result->execute($text, $header_Image_ID, $id);

            return true;
        }
    }
?>