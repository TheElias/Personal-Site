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

 //$imageTypes = Image::fetchAllImageTypes();
?>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/adminStyle.css">
    </head>        

<html  lang="en">
    <body>
        <?php header("Location:" . "imageAdmin.php"); ?>
    </body>
</html>
