
<?php

$isLoggedIn = false;

if(!isset($_SESSION)) 
{
session_start();
}

if (!isset($_SESSION['username']))
{
    if (User::checkUserSessionLogin())
    {
        
        $isLoggedIn = true;
    }   
    else
    { 
        echo "Failed Session check";
        echo '<br />' . $_SERVER['REQUEST_URI'];
        //Redirect 
        if ($_SERVER['REQUEST_URI'] != '/manager' )
        {
            header("Location:" . "manager");
        }
    }
}
else 
{
    $isLoggedIn = true;
}

?>