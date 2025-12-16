
<?php

use Site\User;

$isLoggedIn = false;

if (!isset($_SESSION['username']))
{
    if (User::checkUserSessionLogin())
    {
        $isLoggedIn = true;
    }   
    else
    { 
        //Redirect 
        if ($_SERVER['REQUEST_URI'] != '/manager' )
        {
            header("Location: /manager");
        }
    }
}
else 
{
    $isLoggedIn = true;
}

?>