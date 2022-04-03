<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/mainStyle.css">
    </head>
    

    <body>
        <!--Header-->
        <?php 
            include("Assets/Includes/header.php");
        ?>
        
        
<section class="welcome-section">
    
    <?php
    include('Assets/Includes/db_connection.php');

    //$_GET['id'];

    $sql = "SELECT BP.id AS blogPostID, BP.name AS blogPostName, BP.text AS blogPostText, A.username as authorUsername 
            FROM personal_website.blog_post AS BP
            INNER JOIN personal_website.blog_post_author AS BPA ON BP.id = BPA.blog_post_id
            INNER JOIN personal_website.author AS A ON BPA.blog_post_author_id = A.id
            WHERE BP.id =  ?";

    $result = $conn->prepare($sql);
    $result->execute([$_GET['id']]);
    $blogPost = $result -> fetch();

    ?>
        <h1><?php echo $blogPost["blogPostName"]; ?></h1>
        <h3><?php echo $blogPost["authorUsername"]; ?></h3>
        <p><?php echo $blogPost["blogPostText"]; ?></p>
    </section>

        <!--Footer-->
        <?php 
            include("Assets/Includes/footer.php");            
            $conn = null;
            mysqli_close($conn);
        ?>
    </body>
</html>
 