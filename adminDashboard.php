<!DOCTYPE html>

<?php

if(!isset($_SESSION)) 
{
session_start();
}

require_once './Assets/Includes/Classes/User.php';

if (!isset($_SESSION['username']))
{
    if (!User::checkUserSessionLogin())
    {
        header("Location:" . "manager.php");
    }
}


?>

<html  lang="en">
    <body>
        <p>Hi


            <?php 

            $user = new User();

            $user->loadUserByUsername($_SESSION['username']);

            echo $user->getFullName();



            ?>
        </p>
    </body>
</html>
