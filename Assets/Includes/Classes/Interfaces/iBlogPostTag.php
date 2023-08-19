<?php

interface iBlogPostTag {

    public function loadTagByID($ID);
    public function loadTagByName($name);

    public function getID();
    public function getName();

    public function save();
    public static function saveNewTag($name);

    public static function fetchBlogPostsRelatedToTagByID($tagID);
    public static function fetchBlogPostsRelatedToTagByName($name);
    public static function doesTagExistByName($name);
    public static function doesTagExistByID($ID);
}

?>