<?php
        include('Assets/Includes/db_connection.php');
        include('Assets/Includes/blogPostFunctions.php');
        include('Assets/Includes/generalFunctions.php');
        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/BlogPost.php';
        require_once './Assets/Includes/Classes/Image.php';
        //if (isset($params['urlName']))
        //{
        //    header('Location: blogPost.php?postName=' . getBlogPostIDURL($conn,$params['id']));
        //}
        
        $myBlogPost = New BlogPost();
        

        if (!$myBlogPost->loadBlogByURLName($params['urlName']))
        {
            Redirect("http://www.eliasbroniecki.com/404.php");
        }    

        $headerImage = $myBlogPost->getHeaderImage();
        if ($headerImage == false)
        {
            $headerImage = new Image;
            $headerImage->loadImageByID(1);
        }

    ?> 

<!DOCTYPE html>
    
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $myBlogPost->getTitle() . " - " . $myBlogPost->getAuthorUsername() ;?></title>
        <link rel="stylesheet" type="text/css" href="../Assets/CSS/mainStyle.css">
        <link rel="stylesheet" href="../Assets/CSS/styles/default.min.css">
        <script src="../Assets/CSS/highlight.min.js"></script>
        <script>hljs.highlightAll();</script>
    </head>
    
    <body>
        <!--Header-->
        <?php 
            include("Assets/Includes/header.php");
        ?>
        <section id="page-body">
            <section class="blog-post-section">
                <div class="container">
                
                    <div class="blog-post-header">

                        <img class="blog-post-header-image" src="<?php echo $headerImage->getFullFileLocation(); ?>">
                        <div class="blog-post-title-section font-lightweight">
                            <p id="blog-post-title" class="font-extrabold"><?php $myBlogPost->getTitle(); ?></h1>
                            <div id="blog-post-metadata">
                                <p id="blog-post-time-to-read"><?php print $myBlogPost->getEstimatedReadTime(); ?> Minute Read</p>
                                <p id="blog-post-date-created">Updated: <?php  echo date('F j, o', strtotime($myBlogPost->getDateCreated()) ); //l, jS \o\f F Y ?></p>
                            </div>                    
                        </div>
                        <?php

                            //To list all tags. Uncomment this and SQL above format('l jS \o\f F Y')
                            //foreach($blogTag as $tag) {
                            //    echo "<p>" . $ho["tagName"] . "</p>";
                            //}
                        ?>    
                        <!--<hr size ="1" width="100%"> -->
                    </div>
                    <div class="blog-post-text"><?php echo $myBlogPost->getText(); ?></div>
                    <hr size ="1" width="50%">
                    <h3 class="blog-post-author">By: <?php  echo $blogPost["authorUsername"]; ?></h3>
                
                    <section id="recommended-blog-post-list-section">                
                        <div id="blog-post-recommended-grid-title">
                            <p id="recommended-title">You may also like:</p>
                        </div>  
                        <div id="blog-post-recommended-grid">
                            <?php 
                            
                            $sql = "SELECT BP.id AS blogPostID, BP.urlName, BP.name AS blogPostName, A.username as authorUsername, fnStripTags(BP.text) as myBlogText,
                            CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime, BP.date_created ,header_image_id
                            FROM personal_website.blog_post AS BP
                            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                            WHERE BP.id <> ?
                            ORDER BY BP.id DESC
                            LIMIT 3";
                        
                            $result = $conn->prepare($sql);
                            $result->execute([$blogPost['blogPostID']]);
                            $recommendedPosts = $result->fetchAll(PDO::FETCH_ASSOC); 
                             
                            foreach ($recommendedPosts as $row) 
                            {

                                echo "<div class=\"recommended-blog-post-grid-item\">
                                        <a  href=\"../blog/" . $row["urlName"] . "\">
                                                <img class=\"recommended-blog-post-grid-header-image\" src=\"" . getImageURL($conn, $row["header_image_id"]) . "\" />
                                        </a>
                                        
                                        <div class=\"recommended-blog-post-grid-item-details\">
                                            <div class=\"recommended-blog-post-grid-item-title-section\">

                                                <p href=\"blog/" . $row["urlName"] . "\" class=\"recommended-blog-post-grid-item-title\">" .
                                                    $row["blogPostName"] . 
                                                "</p>
                                        
                                                <div class=\"recommended-blog-post-time-to-read-section\">
                                                    <img src=\"../images/Clock.png\" class=\"recommended-blog-post-estimated-time-clock\") />
                                                    <p class=\"recommended-blog-post-time-to-read\">   " . $row["estimatedReadTime"] . " minute read" . 
                                                    "</p>
                                                </div>
                                            </div>
                                            
                                            <div class=\"recommended-blog-post-grid-blog-text\"><p>" . 
                                                (strlen($row["myBlogText"])>250 ? substr($row["myBlogText"],0,200) . "..." : $row["myBlogText"]) . "
                                                </p>
                                            </div>
                                        
                                        </div>
                                    </div>";
                            }?>
                        </div>    
                    </section>  
                </div>         
            </section>
        </section>
        <!--Footer-->
        <?php 
            include("Assets/Includes/footer.php");            
        ?>
    </body>
</html>
 