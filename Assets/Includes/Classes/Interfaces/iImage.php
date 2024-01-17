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
    public static function doesImageExistByName($name);
    public static function verifyFileLocation($fullFilePath);
    public static function fetchImageFileLocation($id);

    public static function getImageTypeInfoByName($name);
    public static function getImageTypeInfoByID($id);

    public static function getImageTypeIDByName($name);
    public static function getImageTypeNameByID($id);

    public static function fetchAllImageTypes();
    public static function fetchImageList();
    
    //check if file exists in the location and then save the database object
    public static function saveNewImageFromObject($image,$userFriendlyName, $imageType = "General", $destinationFileName, $destinationPath = '');
    public static function saveNewImageFromPath($name,$userFriendlyName, $imageType = "General", $url, $destinationFileName, $destinationPath = '');
    public static function updateImageInfo($id, $name, $fileName, $url);
}

?>