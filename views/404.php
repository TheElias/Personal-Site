<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>404 - YOU LOST HOMIE</title>
        <link rel="stylesheet" type="text/css" href="<?php echo MAIN_CSS_PATH; ?>">
    </head>
    

    <body>
        <!--Header-->
        <?php 
            include(MAIN_HEADER_PATH);


        ?>
        <section id="page-body">
            <section class="page-not-found-section">
                <section class="container">
                    
                    <h2>You Are Lost...</h2>
                    <p>Sorry, the page you are looking for cannot be found.</p>
                    <a href="/">Return Home</a>
                    <?php 
                        php_ini_loaded_file();
                        echo $_SERVER['REQUEST_URI'];
                    ?>
                </section>
            </section>
        </section>
        <!--Footer-->
        <?php 
            include(MAIN_FOOTER_PATH);

        ?>
    </body>
</html>
 