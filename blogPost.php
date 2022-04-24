<?php
        include('Assets/Includes/db_connection.php');
        //General Blog Post Data
        $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, BP.text AS blogPostText, A.username as authorUsername FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                WHERE BP.id =  ?";

        $result = $conn->prepare($sql);
        $result->execute([$_GET['id']]);
        $blogPost = $result -> fetch();

        /*
        //Blog Post Tags
        $sql = "SELECT T.name as tagName FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_tag AS BPT ON BP.id = BPT.blog_post_id
                INNER JOIN personal_website.tag AS T ON BPT.tag_id = T.id
                WHERE BP.id =  ?
                ORDER BY tagName";

        $result = $conn->prepare($sql);
        $result->execute([$_GET['id']]);
        $blogTag =  $result -> fetchAll(PDO::FETCH_ASSOC); 
        */
    ?> 

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $blogPost["blogPostName"] . " - " . $blogPost["authorUsername"];?></title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/mainStyle.css">
    </head>
    
    <body>
        <!--Header-->
        <?php 
            include("Assets/Includes/header.php");
        ?>
        <section class="page-body">
            <section class="blog-post-section">
                <div class="container">
                    <div class="blog-post-title-section">
                        
                        <img src="images/test.png"/>
                        <h1 class="blog-post-title"><?php echo $blogPost["blogPostName"]; ?></h1>
                        <!--<h3 class="blog-post-author">By: <?php  /*echo $blogPost["authorUsername"];*/ ?></h3>-->

                        <?php
                            //To list all tags. Uncomment this and SQL above
                            //foreach($blogTag as $tag) {
                            //    echo "<p>" . $ho["tagName"] . "</p>";
                            //}
                        ?>    
                        <hr size ="1" width="100%">
                    </div>
                    <div class="blog-post-text"><?php echo $blogPost["blogPostText"]; ?></div>
                    <hr size ="1" width="50%">
                    <h3 class="blog-post-author">By: <?php  echo $blogPost["authorUsername"]; ?></h3>
                </div>
                                    
            </section>
        </section>
        <!--Footer-->
        <?php 
            include("Assets/Includes/footer.php");            
        ?>
    </body>
</html>
 