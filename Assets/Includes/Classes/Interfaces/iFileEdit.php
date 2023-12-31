<?php

interface iFileEdit {
    
    public function setSourceFileDirectory($sourceLocation);
    public function setDestination($destinationLocation = "/var/www/eliasbroniecki.com/html/images/");
    public function setFileSaveName($fileName);

    public function getSource();
    public function getDestination();
    public function getFileSaveName();

    public function uploadFileFromObject();
    public function uploadFileFromPath();

    public static function doesDirectoryExist($directory);
    public static function doesFileExist($fileName, $fileLocation = "/var/www/eliasbroniecki.com/html/images/");
    public static function downloadFile($fileName, $fileLocation = "/var/www/eliasbroniecki.com/html/images/");
    public static function getListOfFiles($fileLocation= "/var/www/eliasbroniecki.com/html/images/");
    public static function updateFileName($newFileName, $fileName, $fileLocation = "/var/www/eliasbroniecki.com/html/images/");



}

?>