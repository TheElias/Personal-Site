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
                <div class="message centerItems"><?php if($message!="") { echo $message; } ?></div>

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
                        <input type="submit" name="submit" value="Submit"
                            class="full-width ">
                    </div>
                </div>
            </form>
        </section>
    </body>
</html>
