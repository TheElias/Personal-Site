<?php

namespace Site\Interfaces;

interface iImage {

    public function loadImageByID($ID);
    public function loadImageByName($name);
    public function loadImageByFileName($fileName);

    public function getID();
    public function getName();
    public function getFileName();
    public function getURL();
    public function getFullFileLocation();

    public static function doesImageExist($id);
    public static function doesImageExistByName($name);
    public static function verifyFileLocation($fullFilePath);
    public static function fetchImageFileLocation($id);

    public static function fetchImageList();
    
    //check if file exists in the location and then save the database object
    public static function saveNewImageFromObject($image,$userFriendlyName, $destinationFileName, $destinationPath = '');
    public static function saveNewImageFromPath($name,$userFriendlyName, $url, $destinationFileName, $destinationPath = '');
    public static function updateImageInfo($id, $name, $fileName, $url);
}

?>