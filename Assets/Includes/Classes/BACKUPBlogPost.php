<?php
        include('../Assets/Includes/Database.php');
        include('../Assets/Includes/iBlogPost.php');

    class BlogPost implements iBlogPost
    {
        protected $conn;
        protected $blogID;
        protected $urlname;
        protected $authorUsername;
        protected $blogText;
        protected $estimatedReadTime;
        protected $tags = array();

       /* $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
                BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id 
                FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                WHERE BP.urlName =  ?";
*/

        function __construct($blogURLName)
        {   
            $this->urlname = $blogURLName;

            $this->conn = new Database();
            $this->conn->connect();

            $this->getBlogInformation();
        }

        private function getBlogInformation()
        {
            $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime,
            BP.text AS blogPostText, A.username as authorUsername, header_image_id AS headerID, BP.date_created,header_image_id 
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE BP.urlName =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute($this->urlname);
            $blogPostInfo = $result -> fetch();  

            $this->blogID =  $blogPostInfo["blogPostID"];
            $this->authorUsername =  $blogPostInfo["authorUsername"];
            $this->blogText =  $blogPostInfo["blogPostText"];
            $this->estimatedReadTime =  $blogPostInfo["estimatedReadTime"];
            
        }


        public function getBlogTextSnippet ($length = 250)
        {
            $textSnippet = (strlen($this->blogText)>$length ? substr($this->blogText,0,$length) . "..." : $this->blogText);
            return $textSnippet;
        }

        public static function createBlogEntry($postName, $blogText, $headerImageID, $urlName) 
        {

        }


        public static function addTagToBlogPost($blogID, $tagName) 
        {

        }

        private function fetchTags() 
        {
            $sql = "SELECT tag.* FROM personal_website.tag 
            INNER JOIN blog_post_tag ON tag.id = blog_post_tag.id 
            INNER JOIN blog_post ON blog_post.id = blog_post_tag.blog_post_id
            WHERE blog_post.id = ?";

            $result = $this->conn->prepare($sql);
            $result->execute($this->urlname);
            $blogTags = $result -> $result->fetchAll(PDO::FETCH_ASSOC);
            

            foreach ($blogTags as $row) 
            {

            }
            return array();
        }
        /*
        TODO



        private function getBlogPostIDURL()
        {
            //$blogPostID = empty($blogPostID) ? 1 : $blogPostID;

            $sql = "SELECT * FROM personal_website.image 
            WHERE id =  ?";
            
            $result = $conn->prepare($sql);
            $result->execute($this->blogID);
            $postResult = $result -> fetch();
            
            if (mysqli_num_rows($postResult)==0)
            {
                return getBlogPostIDURL($conn, 1);
            }
            else
            {
                return $postResult['urlName'];
            }
        }
        

        public static function updateBlogEntry() {
            
        }

        private function getTagID() 
        {

        }



        public static function
        */

        
        
    }
?>