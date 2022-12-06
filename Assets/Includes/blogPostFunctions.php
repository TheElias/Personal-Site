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

    return "../" . $imageResult['URL'] . $imageResult['file_name'];
}

function getBlogPostIDURL($conn, $blogPostID)
{
    $blogPostID = empty($blogPostID) ? 1 : $blogPostID;

    $sql = "SELECT * FROM personal_website.image 
    WHERE id =  ?";
    
    $result = $conn->prepare($sql);
    $result->execute([$blogPostID]);
    $postResult = $result -> fetch();
    
    if (mysqli_num_rows($postResult)==0)
    {
        return getBlogPostIDURL($conn, 1);
    }
    else
    {
        return $postResult['urlName'];
    }

}

?>