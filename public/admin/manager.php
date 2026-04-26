<?php

use Site\UserLogin;
use Site\User;
require __DIR__ . '/Assets/Includes/init.php';


if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Decide login state via code, not a global
$isLoggedIn = UserLogin::checkUserSessionLogin();

if ($isLoggedIn) {
    header("Location: adminDashboard.php");
    exit;
}

/*
if (isset($_SESSION['username']))
{
    header("Location:" . "adminDashboard.php");
}
else
{
    if (User::checkUserSessionLogin())
    {
        echo $_SESSION['username'];
        //header("Location:" . "adminDashboard.php");
    }
}
*/
if (! empty($_POST["login"])) {
    $isAuthenticated = false;
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = $_POST["remember"];

    $user = new User();
    if ($user->login($username, $password, $remember)) 
    {
        header("Location:" . "admin");
    }
    else
    {
        $message = "Invalid Login";
    }
}
?>
<!DOCTYPE html>
<html  lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Elias Broniecki Manager Admin Interface For Website Stuff. This is a long title just to make you look.</title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/adminStyle.css">
    </head>

    <body class="centerItems">
    
        <section class="container centerItems">
            <form name="frmAdminLogin" method="post" action="">
                <div class="message centerItems"><?php if(isset($message)) { echo $message; } ?></div>

                <h1 id="login-form-title" class="centerItems">Login</h1>

                <div>
                    <div class="row centerItems">
                        <label>Username:</label> <input type="text" name="username"
                            class="full-width"  required>
                    </div>
                    <div class="row centerItems">
                        <label>Password:</label> <input type="password" name="password"
                            class="full-width" required>
                    </div>
                    <div class="row centerItems">
                        <input type="checkbox" name="remember" checked="true"/> 
                        <label for="remember">Remember Me</label>
                    </div>
                    <div class="row centerItems">
                        <input type="submit" name="login" value="Login"
                            class="full-width ">
                    </div>
                </div>
            </form>
        </section>
    </body>
</html>
