<?php

interface iBlogPost {

    public function loadBlogByID($id=1);
    public function loadBlogByURLName($urlName);
    public function loadBlogByTitle($blogPostTitle);

    public function fetchTags($blogID);
    public function getBlogTextSnippet($length = 250);
    
    public static function doesBlogPostExistByID($id);
    public static function doesBlogPostExistByName($name);
    public static function doesBlogPostExistByURLName($urlName);
    public static function addTagToBlogPost($blogID, $tagName);


    public static function saveNewBlogPost($name, $text, $urlName, $header_Image_ID=1);
    public static function updateBlogPost($id, $name, $text, $urlName, $header_Image_ID=1);

}

?>