<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="<?php echo MAIN_CSS_PATH; ?>">
    </head>
<?php 

?>

    <body>


        <!--Header-->
        <?php 
            include(MAIN_HEADER_PATH);
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
            include(MAIN_FOOTER_PATH);
        ?>
    </body>
</html>
 