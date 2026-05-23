<!DOCTYPE html>

<?php



if(isset($_FILES['image']))
{
    //echo "<br /> Image Object" . var_dump($_FILES['image']) . "<br /> User Friendly Name: " . $_POST['userFriendlyName'] . "<br />  Image Type: " . $_POST['imageType'] . "<br /> Destination File Name: " . $_POST["destinationFileName"], "<br />";
  /*  if (!Image::saveNewImageFromObject($_FILES['image'],$_POST['userFriendlyName'],$_POST['imageType'],$_POST["destinationFileName"]))
    {
        $message = "Failed Image Upload";
    }*/
}

 //$imageTypes = Image::fetchAllImageTypes();
?>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_PATH; ?>">
    </head>        
        <!--Header-->
        <?php 
            include MAIN_ADMIN_HEADER_PATH;
        ?>

<html  lang="en">
    <body>
        <?php /*header("Location:" . "imageAdmin.php"); */ ?>
    </body>
</html>
