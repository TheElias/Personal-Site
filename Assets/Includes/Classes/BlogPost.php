<?php
        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/Interfaces/iBlogPost.php';
        require_once './Assets/Includes/Classes/BlogPostTag.php';
        require_once './Assets/Includes/Classes/Image.php';
        require_once './Assets/Includes/Classes/User.php';

    class BlogPost implements iBlogPost
    {
        protected $database;
        protected $conn;
        protected $blogID;
        protected $urlName;
        protected $authors = array();
        protected $blogText;
        protected $title;
        protected $estimatedReadTime;
        protected $dateCreated;
        protected $headerImageID;
        protected $tags = array();

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn = $this->database->getConnection();
        }

        public function loadBlogByID($id=1)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime, date_created,
            BP.text AS blogPostText, U.id as authorID, BP.date_created,header_image_id as headerImageID, urlName 
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.user AS U ON BPA.user_id = U.id
            WHERE BP.id =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$id]);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            $this->blogID = $id;
            $this->urlName =$blogPostInfo['urlName'];
            $this->authors = BlogPost::fetchAuthors($id);
            $this->blogText = $blogPostInfo['blogPostText'];
            $this->urlName = $blogPostInfo['urlName'];
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->dateCreated = $blogPostInfo['date_created'];
            $this->title = $blogPostInfo['blogPostName'];
            $this->headerImageID = $blogPostInfo['headerImageID'];
            $this->tags = BlogPost::fetchTags($id);

            return true;
        }

        public function loadBlogByURLName($urlName)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,date_created,
            BP.text AS blogPostText, U.id as authorID, BP.date_created,header_image_id as headerImageID, urlName
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.user AS U ON BPA.user_id = U.id
            WHERE BP.urlName =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$urlName]);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            $this->blogID = $blogPostInfo['blogPostID'];
            $this->urlName = $urlName;
            $this->authors = BlogPost::fetchAuthors($blogPostInfo['blogPostID']);
            $this->blogText = $blogPostInfo['blogPostText'];
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->urlName = $blogPostInfo['urlName'];
            $this->dateCreated = $blogPostInfo['date_created'];
            $this->title = $blogPostInfo['blogPostName'];
            $this->headerImageID = $blogPostInfo['headerImageID'];
            $this->tags = BlogPost::fetchTags($blogPostInfo['blogPostID']);

            return true;
        }
        public function loadBlogByTitle($blogPostTitle)
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostTitle, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime, date_created,
            BP.text AS blogPostText, U.username as authorUsername, BP.date_created,header_image_id as headerImageID, urlName
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS U ON BPA.user_id = U.id
            WHERE BP.name =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$blogPostTitle]);
            $blogPostInfo = $result -> fetch();  
            
            if (!$blogPostInfo) {
                return false;
            }
            
            $this->blogID = $blogPostInfo['blogPostID'];
            $this->urlName = $blogPostInfo['blogPostID'];
            $this->authors = BlogPost::fetchAuthors($blogPostInfo['blogPostID']);
            $this->blogText = $blogPostInfo['blogPostText'];
            $this->urlName = $blogPostInfo['urlName'];
            $this->estimatedReadTime = $blogPostInfo['estimatedReadTime'];
            $this->dateCreated = $blogPostInfo['date_created'];
            $this->title = $blogPostTitle;
            $this->headerImageID = $blogPostInfo['headerImageID'];
            $this->tags = BlogPost::fetchTags($blogPostInfo['blogPostID']);

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
        
        public function getAuthors()
        {
            if (empty($this->authors))
            {
                return false;
            }
            return $this->authors; 
        }

        public function formatAuthors()
        {
            if (empty($this->authors))
            {
                return false;
            }
            return $this->authors; 
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
                $myImage->loadImageByID(1);
            }

            return $myImage;
        }

        public function getHeaderImageFullPath()
        {
            $myImage = $this->getHeaderImage();

            if (!$myImage) 
            {
                $myImage->loadImageByID(1);
            }

            return $myImage->getFullFileLocation();
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
            }

            $myTag = new BlogPostTag;
            $myTag->loadTagByName($tagName);

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();            

            $sql = "INSERT INTO blog_post_tag (blogID, tagID) VALUES (?,?)";

            $result = $conn->prepare($sql);
            $result->execute([$blogID,$myTag->getID()]);
            $tagInfo = $result -> fetch();  

            if (!$tagInfo)
            {
                return false;
            }
            
            return $tagInfo;
        }

           
        public static function fetchTags($blogID)
        {
            if (BlogPost::doesBlogPostExistByID($blogID))
            {
                return false;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT T.id as 'TagID'
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_tag AS BPT ON BPT.blog_post_id = BP.id
            INNER JOIN personal_website.tag AS T ON T.it = BPT.tag_id
            WHERE BP.ID =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$blogID]);
            $tags = $result->fetchAll(PDO::FETCH_ASSOC); 

            if (!$tags) {
                return false;
            }

            $myTagsObjects = array();

            foreach ($tags as $row) 
            {
                $tags = new BlogPostTag();
                $tags->loadTagByID($row["TagID"]);

                array_push($myTagsObjects, $tags);
            }

            return $myTagsObjects;
        }

        public static function fetchAuthors($blogID)
        {
            if (!BlogPost::doesBlogPostExistByID($blogID))
            {
                return false;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT U.id as 'User ID'
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.user AS U ON BPA.user_id = U.id
            WHERE BP.ID =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$blogID]);
            $authors = $result->fetchAll(PDO::FETCH_ASSOC); 
            
            if (!$authors) {
                return false;
            }

            $extracedAuthors = array();

            foreach ($authors as $row) 
            {
                $fecthedAuthor = new User();
                $fecthedAuthor->loadUserByID($row["User ID"]);

                array_push($extracedAuthors, $fecthedAuthor);
            }

            return $extracedAuthors;
        }


        public static function fetchRecommendedPosts($blogID, $count)
        {
            
            if (!BlogPost::doesBlogPostExistByID($blogID))
            {
                return false;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT BP.id AS blogPostID, BP.urlName, BP.name AS blogPostName, U.username as authorUsername, fnStripTags(BP.text) as myBlogText,
                    CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime, BP.date_created ,header_image_id, urlName
                    FROM personal_website.blog_post AS BP
                    INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                    INNER JOIN personal_website.user AS U ON BPA.user_id = U.id
                    WHERE BP.id <> :myID
                    ORDER BY BP.id DESC
                    LIMIT :myLimit";

            $result = $conn->prepare($sql);
            $result->bindParam(":myID", $blogID, PDO::PARAM_INT);
            $result->bindParam(":myLimit", $count, PDO::PARAM_INT);
            $result->execute();
            $recommendedPosts = $result->fetchAll(PDO::FETCH_ASSOC); 

            if (!$recommendedPosts) {
                return false;
            }

            $myPosts = array();

            foreach ($recommendedPosts as $row) 
            {
                
                $testBlogPost = new BlogPost();
                $testBlogPost->loadBlogByID($row["blogPostID"]);

                array_push($myPosts, $testBlogPost);
            }

            return $myPosts;
        }

        public static function fetchAllPosts()
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT BP.id AS blogPostID
                    FROM personal_website.blog_post AS BP
                    INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                    INNER JOIN personal_website.user AS U ON BPA.user_id = U.id
                    ORDER BY BP.id DESC";

            $result = $conn->prepare($sql);
            $result->execute();
            $allPosts = $result->fetchAll(PDO::FETCH_ASSOC); 

            if (!$allPosts) {
                return false;
            }

            $myPosts = array();

            foreach ($allPosts as $row) 
            {
                $testBlogPost = new BlogPost();
                $testBlogPost->loadBlogByID($row["blogPostID"]);

                array_push($myPosts, $testBlogPost);
            }

            return $myPosts;
        }
    
        public static function insertNewBlogPost($name, $text, $urlName)
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

            $sql = "INSERT INTO blog_post_tag (name, text, urlName) VALUES (?,?,?)";

            $result = $conn->prepare($sql);
            $result->execute($name, $text, $urlName);

            if (!BlogPost::doesBlogPostExistByName($name))
            {
                return false;
            }
            return true;
        }
        public static function updateBlogPost($id, $text)
        {   
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            if (!BlogPost::doesBlogPostExistByID($id))
            {
                return false;
            }

            $sql = "";//"UPDATE blog_post_tag (text) WHERE  id = ?";

            $result = $conn->prepare($sql);
            $result->execute([$text, $id]);

            return true;
        }
    }
?>