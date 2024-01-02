
<?php

$isLoggedIn = false;

if(!isset($_SESSION)) 
{
session_start();
}

if (!isset($_SESSION['username']))
{
    echo "no session";
    if (!User::checkUserSessionLogin())
    {
        //Redirect 
        if (!$_SERVER['REQUEST_URI'] = '/manager' )
        {
            header("Location:" . "manager");
        }
    }
    else
    { 
        $isLoggedIn = true;
    }
}
else 
{
    $isLoggedIn = true;
}

?>