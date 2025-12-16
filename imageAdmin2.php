
<?php
require __DIR__ . '/Assets/Includes/init.php';
use Site\Image;
?>

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

if(isset($_FILES['imageEdited']))
{
    //echo "<br /> Image Object" . var_dump($_FILES['image']) . "<br /> User Friendly Name: " . $_POST['userFriendlyName'] . "<br />  Image Type: " . $_POST['imageType'] . "<br /> Destination File Name: " . $_POST["destinationFileName"], "<br />";
    if (!Image::saveNewImageFromObject($_FILES['imageEdited'],$_POST['userFriendlyName'],$_POST['imageType'],$_POST["destinationFileName"]))
    {
        $message = "Failed Image Upload";
    }
}

// $imageTypes = Image::fetchAllImageTypes();
?>


<html  lang="en">
    <body >
    <?php include("Assets/Includes/adminHeader.php"); ?>
        <section class="page-body centerItems">
            <section class="image-form-section">
            <form action="" name="myForm" method="POST" enctype="multipart/form-data">

                <div class="message centerItems"><?php  if(isset($message)) { echo $message; }  ?></div>

                <div class="formTextInputs">
                    <label for="userFriendlyName">User Friendly File Name(Maeby On Couch):</label>
                    <input type="text" name="userFriendlyName" class="full-width"  required>

                    <label for="destinationFileName">Destination File Name (Include file type such as Maeby.png):</label>
                    <input type="text" name="destinationFileName" class="full-width"  required>
                </div>

                <input type="file" name="imageEdited" accept="image/" onchange="previewImage(event)" required/>
                <img id="preview" name="preview" alt="Preview Image">
                <input type="submit"/>
            </form>
           

            
        </section>
            <section class="container">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image Name</th>
                            <th scope="col">Image File Name</th>
                            <th scope="col">URL</th>
                            <th scope="col">Image</th>
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
                                        <td data-title=\"URL\">
                                            <a href = 'HTTP://" . $_SERVER['HTTP_HOST']  . "/" .  $row['URL'] . $row['imageFileName'] ."'>
                                                HTTP://" . $_SERVER['HTTP_HOST']  . "/" .  $row['URL'] . "
                                            </a>
                                        </td>
                                        <td data-title=\"Image Type\"><img src='HTTP://" . $_SERVER['HTTP_HOST']  . "/" .  $row['URL'] . $row['imageFileName'] ."'></td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </section>
        </section>
       
        
                    
    </body>
</html>
