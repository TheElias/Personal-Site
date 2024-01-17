
<!DOCTYPE html>
<head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="Assets/CSS/adminStyle.css">
        <script type="text/javascript">
            function previewImage(event) {
                var input = event.target;
                var image = document.getElementById('preview');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    image.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <style>
            #preview {
                width: 300px;
                height: 300px;
            }
        </style>
    </head>        

<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/User.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Image.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/FileEdit.php';

include("Assets/Includes/loginCheck.php");


if(isset($_FILES['imageEdited']))
{
    //echo "<br /> Image Object" . var_dump($_FILES['image']) . "<br /> User Friendly Name: " . $_POST['userFriendlyName'] . "<br />  Image Type: " . $_POST['imageType'] . "<br /> Destination File Name: " . $_POST["destinationFileName"], "<br />";
    if (!Image::saveNewImageFromObject($_FILES['image'],$_POST['userFriendlyName'],$_POST['imageType'],$_POST["destinationFileName"]))
    {
        $message = "Failed Image Upload";
    }
}

 $imageTypes = Image::fetchAllImageTypes();
?>


<html  lang="en">
    <body >
    <?php include("Assets/Includes/adminHeader.php"); ?>
        <section class="page-body centerItems">
            
            <section class="container">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image Name</th>
                            <th scope="col">Image File Name</th>
                            <th scope="col">URL</th>
                            <th scope="col">Image Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $myList = Image::fetchImageList();
                            
                            foreach ($myList as $row) 
                            {
                                echo "<tr>
                                        <th scope=\"row\">" .  $row['ImageID'] . "</th>
                                        <td data-title=\"Image Name\">" .  $row['imageName'] . "</td>
                                        <td data-title=\"Image File Name\">" .  $row['imageFileName'] . "</td>
                                        <td data-title=\"URL\">" .  $row['URL'] . "</td>
                                        <td data-title=\"Image Type\">" .  $row['imageTypeName'] . "</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </section>
        </section>
       
        <section class="image-form-section">
            <form action="" name="myForm" method="POST" enctype="multipart/form-data">

                <div class="message centerItems"><?php  if(isset($message)) { echo $message; }  ?></div>

                <div class="formTextInputs">
                    <label for="userFriendlyName">User Friendly File Name:</label>
                    <input type="text" name="userFriendlyName" class="full-width"  required>

                    <label for="destinationFileName">Destination File Name (Include file type):</label>
                    <input type="text" name="destinationFileName" class="full-width"  required>
                </div>

                <label for="imageType">Choose an Image Type:</label>
                <select id="imageType" name="imageType" required>
                    <?php 
                    
                        foreach ($imageTypes as $row) 
                        {
                            echo "<option value = \"" . $row['name'] . "\">" . $row['name'] . "</option>";
                        } 
                    ?>
                </select>   
                <input type="file" name="imageEdited" accept="image/" onchange="previewImage(event)" required/>
                <img id="preview" name="preview" alt="Preview Image">
                <input type="submit"/>
            </form>
           

            
        </section>
                    
    </body>
</html>
