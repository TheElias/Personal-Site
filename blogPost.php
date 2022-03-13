<!DOCTYPE html>
<html>
    <?php
        include('Assets/Includes/db_connection.php');

        $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, BP.text AS blogPostText, A.username as authorUsername FROM personal_website.blog_post AS BP
                INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
                INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
                WHERE BP.id =  ?";

        $result = $conn->prepare($sql);
        $result->execute([$_GET['id']]);
        $blogPost = $result -> fetch();
    ?>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $blogPost["blogPostName"] . " - " . $blogPost["authorUsername"];?></title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/mainStyle.css">
    </head>
    
    <body>
        <!--Header-->
        <?php 
            include("Assets/Includes/header.php");
        ?>
        
        <section class="container blog-post-section">
            
                <h1 class="blog-post-title"><?php echo $blogPost["blogPostName"]; ?></h1>
                <h3 class="blog-post-author">By: <?php echo $blogPost["authorUsername"]; ?></h3>
                <hr size ="1" width="100%">
                <div class="blog-post-text"><?php echo $blogPost["blogPostText"]; ?></div>
        </section>

        <!--Footer-->
        <?php 
            include("Assets/Includes/footer.php");            
        ?>
    </body>
</html>
 