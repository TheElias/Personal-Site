<?php

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
    public static function verifyFileLocation($fullFilePath);

    //check if file exists in the location and then save the database object
    public static function saveNewImage($name, $url, $fileName);

    public static function updateImage($id, $name, $fileName, $url);

    public static function fetchImageFileLocation($id);

}

?>