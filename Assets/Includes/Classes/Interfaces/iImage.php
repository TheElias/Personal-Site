<?php

interface iImage {

    public function loadImageByID($ID);
    public function loadImageByName($name);
    public function loadImageByFileName($fileName);
    public function loadImageByBlogPostIDAndImageType($blogPostID,$typeName);

    public function getID();
    public function getName();
    public function getFileName();
    public function getURL();
    public function getFullFileLocation();
    public function getImageTypeID();
    public function getImageTypeName();

    public static function doesImageExist($id);
    public static function verifyFileLocation($fullFilePath);
    public static function fetchImageFileLocation($id);

    public static function getImageTypeIDByName($name);
    public static function getImageTypeNameByID($id);
    
    //check if file exists in the location and then save the database object
    public static function saveNewImage($name, $url, $fileName);
    public static function updateImageInfo($id, $name, $fileName, $url);
}

?>