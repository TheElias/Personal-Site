<footer>
    <!--Navigation-->
    <?php 
        include(__DIR__  . "/socialMedias.php");
        if (isset($conn) )
        {
            mysqli_close($conn);
        }
    ?>
</footer>