<!DOCTYPE html>

<?php

if(!isset($_SESSION)) 
{
session_start();
}

require_once './Assets/Includes/Classes/User.php';
require_once './Assets/Includes/Classes/Image.php';
require_once './Assets/Includes/Classes/FileEdit.php';

if (!isset($_SESSION['username']))
{
    if (!User::checkUserSessionLogin())
    {
        header("Location:" . "manager.php");
    }
}


if(isset($_FILES['image']))
{
    echo 'startImageSave';
    var_dump(Image::saveNewImageFromObject($_FILES['image'],$_POST['userFriendlyName'],$_POST['imageType'],$_POST["destinationFileName"]));
    echo 'endImageSave';
}

 $imageTypes = Image::fetchAllImageTypes();
?>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/adminStyle.css">
    </head>        

<html  lang="en">
    <body>

        <p>Hi


            <?php 

            $user = new User();

            $user->loadUserByUsername($_SESSION['username']);

            echo $user->getFullName();

            ?>
        </p>

        <form action="" method="POST" enctype="multipart/form-data">

        <label for="userFriendlyName">User Friendly File Name:</label>
        <input type="text" name="userFriendlyName" class="full-width"  required>

        <label for="destinationFileName">Destination File Name (Include file type):</label>
        <input type="text" name="destinationFileName" class="full-width"  required>

        <label for="imageType">Choose an Image Type:</label>
        <select id="imageType" name="imageType" required>
            <?php 
                echo "<p>" . var_dump($imageTypes) . "</p>";

                foreach ($imageTypes as $row) 
                {
                    echo "<option value = \"" . $row['id'] . "\">" . $row['name'] . "</option>";
                }
            ?>
        </select>   
         <input type="file" name="image" required/>
         <input type="submit"/>
      </form>
    </body>
</html>
