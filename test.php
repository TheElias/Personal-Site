<?php
include('Assets/Includes/Classes/Database.php');

$testDatabase = new Database();
$testDatabase->Database();
$testDatabase->connect();
$mydata = $testDatabase->selectAll("blog_post");
foreach ($mydata as $row) 
{
    echo $row["name"];
}

?>