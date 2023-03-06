<?php

        include('Assets/Includes/db_connection.php');
        include('Assets/Includes/blogPostFunctions.php');
       // include('Assets/Includes/MarkdownExtra.php');

        $sql = "SELECT BP.id AS blogPostID, BP.urlName, BP.name AS blogPostName, A.username as authorUsername, fnStripTags(BP.text) as myBlogText, 
                CEILING(((CHAR_LENGTH(BP.text)/4.7)/225)) AS estimatedReadTime, BP.date_created,header_image_id
                FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                ORDER BY BP.id DESC";

            $result = $conn->prepare($sql);
            $result->execute();
            $blogPost = $result->fetchAll(PDO::FETCH_ASSOC); 
            
    ?> 

<!DOCTYPE html>
<html  lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Elias' Blog with thoughts and projects!</title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/mainStyle.css">
    </head>
    
    <body>
        <!--Header-->
        <?php 
            include("Assets/Includes/header.php");
        ?>
        
        <section id="page-body">
            <section class="blog-post-list-section">
                <div class="container">
                
                    <div class="blog-post-list-grid-section-title">
                        <h1 class="blog-home-page-title">Blog!</h1>
                    </div>
                    <div class="blog-post-list-grid-section">
                        <?php foreach ($blogPost as $row) 
                        {
                            echo "<div class=\"blog-grid-item\">
                                    <a  href=\"blog/" . $row["urlName"] . "\">
                                            <img class=\"blog-post-grid-header-image\" src=\"" . getImageURL($conn, $row["header_image_id"]) . "\" />
                                    </a>
                                    
                                    <div class=\"blog-post-grid-item-details\">
                                        <div class=\"blog-post-grid-item-title-section\">

                                            <p href=\"blog/" . $row["urlName"] . "\" class=\"blog-post-grid-item-title\">" .
                                                $row["blogPostName"] . 
                                            "</p>
                                    
                                            <div class=\"blog-post-grid-time-to-read-section\">
                                                <img src=\"../images/Clock.png\" class=\"blog-grid-estimated-time-clock\") />
                                                <p class=\"blog-post-grid-time-to-read\">   " . $row["estimatedReadTime"] . " minute read" . 
                                                "</p>
                                            </div>
                                        </div>
                                           
                                        <div class=\"blog-post-grid-blog-text\"><p>" . 
                                            (strlen($row["myBlogText"])>250 ? substr($row["myBlogText"],0,200) . "..." : $row["myBlogText"]) . "
                                            </p>
                                        </div>
                                     
                                    </div>
                                </div>";

                            
                        }?>
                    </div>
                </div>
            </section>
            
            
        </section>
        

        <!--Footer-->
        <?php 
            include("Assets/Includes/footer.php");    
        ?>

        
    </body>
</html>
 