<?php

function getBlogPostHeaderImage($conn, $image_id)
{
    //Satanically/Synatically \m/...(>.<)…\m/

    $image_id = empty($image_id) ? 1 : $image_id;

    $sql = "SELECT * FROM personal_website.image 
    WHERE id =  ?";
    
    $result = $conn->prepare($sql);
    $result->execute([$image_id]);
    $imageResult = $result -> fetch();

    return $imageResult['URL'] . $imageResult['file_name'];
}

?>