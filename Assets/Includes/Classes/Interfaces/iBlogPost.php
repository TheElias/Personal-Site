<?php

interface iBlogPost {

    public function loadBlogByID($id=1);
    public function loadBlogByURLName($urlName);
    public function loadBlogByTitle($blogPostTitle);

   
    
    public function getID();
    public function getText();
    public function getURLName();
    public function getAuthorUsername();
    public function getAuthorFullName();
    public function getTitle();
    public function getTags();
    public function getEstimatedReadTime();
    public function getDateCreated();
    public function getBlogTextSnippet($length = 250);
    public function getHeaderImage();   
    public function getHeaderImageFullPath();
    
    public static function doesBlogPostExistByID($id);
    public static function doesBlogPostExistByName($name);
    public static function doesBlogPostExistByURLName($urlName);
    public static function addTagToBlogPost($blogID, $tagName);
    public static function fetchAllPosts();

    public static function fetchTags($blogID);
    public static function fetchRecommendedPosts($blogID, $count);

    public static function insertNewBlogPost($name, $text, $urlName, $header_Image_ID=1);
    public static function updateBlogPost($id, $text, $header_Image_ID=1);

}

?>