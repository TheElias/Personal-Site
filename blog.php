<?php

        include('Assets/Includes/db_connection.php');
        include('Assets/Includes/blogPostFunctions.php');

        $sql = "SELECT BP.id AS blogPostID, BP.urlName, BP.name AS blogPostName, A.username as authorUsername FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                ORDER BY BP.id DESC
                LIMIT 3";

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
        
        <section class="page-body">
            <section class="blog-post-list-section">
                <div class="container">
                    <div class="blog-post-list-grid-section-title">
                        <h1 class="blog-home-page-title">Blog!</h1>
                    </div>
                    <div class="blog-post-list-grid-section">
                        <?php foreach ($blogPost as $row) 
                        {
                            
                            echo "<div class=\"blog-grid-item\">";
                            echo "<a href=\"blog/" . $row["urlName"] . "\">";
                            echo "<img href=\"blog/" . $row["urlName"] . "\" class=\"blog-post-small-header-image\" src=\"" . getBlogPostHeaderImage($conn, $blogPost["blogPostID"]) . "\" />";
                            echo "<p class=\"blog-post-grid-item-title\">" .
                                    $row["blogPostName"] . 
                                "</p>
                                
                                </a>
                                </div>";

                            /*echo "<a href=\"/blogPost.php?id=" . $row["blogPostID"] . "\"  class=\"blog-post-grid-title\"> 
                                <p>" .
                                    $row["blogPostName"] . 
                                "</p>
                            </a>";*/
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
 