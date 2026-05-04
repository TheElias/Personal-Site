<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="/assets/CSS/mainStyle.css">
    </head>
<?php 

use Site\View\View;

?>

    <body>


        <!--Header-->
        <?php 
            include(__DIR__  . "/../templates/partials/header.php");
        ?>


        <section class="welcome-section">
            <h2>Fart</h2>
            <a href = "https://eliasbroniecki.com/imageAdmin.php">Go to my blog</a>
        </section>

        <section class="about-me-section">
            <h2>About Me</h2>
            <p>Creating Whatever</p>
        </section>

        <section class="projects-section">
            <h2>Projects</h2>
            <p>MahProjects</p>
        </section>

        <!--Footer-->
        <?php 
            include(__DIR__  . "/../templates/partials/footer.php");
        ?>
    </body>
</html>
 