<footer>
    <!--Navigation-->
    <?php 
        include("Assets/Includes/socialMedias.php");
        if (isset($conn) )
        {
            mysqli_close($conn);
        }
    ?>
</footer>