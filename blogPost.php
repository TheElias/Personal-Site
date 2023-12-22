<?php
        //include('Assets/Includes/db_connection.php');
        //include('Assets/Includes/blogPostFunctions.php');
        //include('Assets/Includes/generalFunctions.php');
        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/BlogPost.php';
        require_once './Assets/Includes/Classes/Image.php';

        $myBlogPost = New BlogPost();
        
        if (!$myBlogPost->loadBlogByURLName($params['urlName']))
        {
            Redirect("http://www.eliasbroniecki.com/404.php");
        }    

        $allAuthors = $myBlogPost->getAuthors();
        $formattedAuthorsArray = array();
        $postAuthorsFormatted;

        foreach ($allAuthors as $author) 
        {
            array_push($formattedAuthorsArray, $author->getFullName());
        }

        $postAuthorsFormatted = implode(", ", $formattedAuthorsArray);
        
        /*
        $headerImage = $myBlogPost->getHeaderImage();
        if ($headerImage == false)
        {
            $headerImage = new Image;
            $headerImage->loadImageByID(1);
        }
        
        if (isset($params['urlName']))
        {
            header('Location: blogPost.php?postName=' . $myBlogPost->getURLName());//getBlogPostIDURL($conn,$params['id'])
        }*/
    ?> 

<!DOCTYPE html>
    
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php  echo $myBlogPost->getTitle() . " - " . $postAuthorsFormatted; ?></title>
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

                        <img class="blog-post-header-image" src="<?php  echo $myBlogPost->getHeaderImageFullPath();  ?>">
                        <div class="blog-post-title-section font-lightweight">
                            <p id="blog-post-title" class="font-extrabold"><?php  echo $myBlogPost->getTitle();  ?></h1>
                            <div id="blog-post-metadata">
                                <p id="blog-post-time-to-read"><?php  echo $myBlogPost->getEstimatedReadTime();  ?> Minute Read</p>
                                <p id="blog-post-date-created">Updated: <?php  echo date('F j, o', strtotime($myBlogPost->getDateCreated()) );  ?></p>
                            </div>                    
                        </div>
                    </div>
                    <div class="blog-post-text"><?php  echo $myBlogPost->getText();  ?></div>
                    <hr size ="1" width="50%">

                    
                    <h3 class="blog-post-author">
                        By: <?php  echo $postAuthorsFormatted;  ?>
                    </h3>
                
                    <section id="recommended-blog-post-list-section">                
                        <div id="blog-post-recommended-grid-title">
                            <p id="recommended-title">You may also like:</p>
                        </div>  
                        <div id="blog-post-recommended-grid">
                            <?php 

                            $recommendedPosts = BlogPost::fetchRecommendedPosts($myBlogPost->getID(),'3');

                            foreach ($recommendedPosts as $row) 
                            {
                                echo "<div class=\"recommended-blog-post-grid-item\">
                                        <a  href=\"../blog/" . $row->getURLName() . "\">
                                                <img class=\"recommended-blog-post-grid-header-image\" src=\"" . '/' . $row->getHeaderImage()->getFullFileLocation() . "\" />
                                        </a>
                                        <div class=\"recommended-blog-post-grid-item-details\">
                                            <div class=\"recommended-blog-post-grid-item-title-section\">

                                                <p href=\"blog/" . $row->getURLName() . "\" class=\"recommended-blog-post-grid-item-title\">" .
                                                $row->getTitle() . 
                                                "</p>
                                        
                                                <div class=\"recommended-blog-post-time-to-read-section\">
                                                    <img src=\"../images/Clock.png\" class=\"recommended-blog-post-estimated-time-clock\") />
                                                    <p class=\"recommended-blog-post-time-to-read\">   " . $row->getEstimatedReadTime() . " minute read" . 
                                                    "</p>
                                                </div>
                                            </div>
                                            
                                            <div class=\"recommended-blog-post-grid-blog-text\"><p>" . 
                                                $row->getBlogTextSnippet(250) . "
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
 