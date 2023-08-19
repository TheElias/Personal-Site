<?php
        include('../Assets/Includes/Classes/Database.php');
        include('../Assets/Includes/Classes/Interfaces/iBlogPost.php');
        include('../Assets/Includes/Classes/BlogPostTag.php');

    class BlogPost implements iBlogPost
    {
        protected $database;
        protected $conn;
        protected $blogID;
        protected $urlname;
        protected $authorUsername;
        protected $blogText;
        protected $title;
        protected $estimatedReadTime;
        protected $tags = array();

       /* $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
                BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id 
                FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                WHERE BP.urlName =  ?";
*/

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
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->title = $blogPostInfo['blogPostName'];

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
            $this->title = $blogPostInfo['blogPostName'];

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
            $this->title = $blogPostTitle;

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
        
        public function getBlogTextSnippet ($length = 250)
        {
            if (empty($this->blogText))
            {
                return false;
            }

            $textSnippet = (strlen($this->blogText)>$length ? substr($this->blogText,0,$length) . "..." : $this->blogText);
            return $textSnippet;
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
                BlogPostTag::saveNewTag($tagName);
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
    
        public static function saveNewBlogPost($name, $text, $urlName, $header_Image_ID=1)
        {
            


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
        public static function updateBlogPost($id, $name, $text, $urlName, $header_Image_ID=1)
        {

        }
    }
?>