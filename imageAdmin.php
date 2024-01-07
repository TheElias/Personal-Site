<!DOCTYPE html>

<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/User.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Image.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/FileEdit.php';

include("Assets/Includes/loginCheck.php");

include("Assets/Includes/adminHeader.php");

if(isset($_FILES['image']))
{
    //echo "<br /> Image Object" . var_dump($_FILES['image']) . "<br /> User Friendly Name: " . $_POST['userFriendlyName'] . "<br />  Image Type: " . $_POST['imageType'] . "<br /> Destination File Name: " . $_POST["destinationFileName"], "<br />";
    if (!Image::saveNewImageFromObject($_FILES['image'],$_POST['userFriendlyName'],$_POST['imageType'],$_POST["destinationFileName"]))
    {
        $message = "Failed Image Upload";
    }
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

        <section class="image-form-section">
            <p>Hi
                <?php 

                $user = new User();
                $user->loadUserByUsername($_SESSION['username']);
                echo $user->getFullName();

                ?>
            </p>

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="message centerItems"><?php if(isset($message)) { echo $message; } ?></div>

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
                            echo "<option value = \"" . $row['name'] . "\">" . $row['name'] . "</option>";
                        }
                    ?>
                </select>   
                <input type="file" name="image" required/>
                <input type="submit"/>
            </form>
        </section>
    </body>
</html>
