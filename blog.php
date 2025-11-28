<?php

    require_once './Assets/Includes/Classes/BlogPost.php';
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
            echo "test";
        ?>
        
        <section id="page-body">
            <section class="blog-post-list-section">
                <div class="container">
                
                    <div class="blog-post-list-grid-section-title">
                        <h1 class="blog-home-page-title">Blog!</h1>
                    </div>
                    <div class="blog-post-list-grid-section">
                        <?php 
                        echo "test2";
                        $allPosts = BlogPost::fetchAllPosts();
                        echo "test3";
                        foreach ($allPosts as $blogPost) 
                        {
                            echo ( "<div class=\"blog-grid-item\">
                                    <a  href=\"blog/" . htmlspecialchars($blogPost->getURLname()) . "\">
                                            <img class=\"blog-post-grid-header-image\" src=\"" . htmlspecialchars($blogPost->getHeaderImageFullPath()) . "\" />
                                    </a>
                                    
                                    <div class=\"blog-post-grid-item-details\">
                                        <div class=\"blog-post-grid-item-title-section\">

                                            <p href=\"blog/" . htmlspecialchars($blogPost->getURLname()) . "\" class=\"blog-post-grid-item-title\">" .
                                            htmlspecialchars($blogPost->getTitle()) . 
                                            "</p>
                                    
                                            <div class=\"blog-post-grid-time-to-read-section\">
                                                <img src=\"../images/Clock.png\" class=\"blog-grid-estimated-time-clock\") />
                                                <p class=\"blog-post-grid-time-to-read\">   " . htmlspecialchars($blogPost->getEstimatedReadTime()) . " minute read" . 
                                                "</p>
                                            </div>
                                        </div>
                                           
                                        <div class=\"blog-post-grid-blog-text\"><p>" . 
                                            date('F j, o', strtotime(htmlspecialchars(($blogPost->getDateCreated()))) ) . "
                                            </p>
                                        </div>
                                     
                                    </div>
                                </div>");
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
 