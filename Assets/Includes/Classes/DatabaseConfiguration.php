<?php

include_once("./Assets/Includes/generalFunctions.php");



class DatabaseConfiguration {
    protected $serverName;
    protected $userName;
    protected $password;
    protected $databaseName;    

    function __construct()
    {
        if(file_exists("X:\Projects\Personal Site\EliasBroniecki.com\Code\ignoredFiles\config.env"))
        {
            $myFile = file_get_contents("X:\Projects\Personal Site\EliasBroniecki.com\Code\ignoredFiles\config.env");
            $myArray = parse_env_file_contents_to_array($myFile);
            //echo  "TEST dbname: " . $myArray["dbname"] . "  Server Name: " . $myArray["servername"] . " Username: " . $myArray["username"] . " password" . $myArray["dbpassword"];
        }
        else
        {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        }

            $this -> databaseName = $myArray["dbname"];
            $this -> serverName = $myArray["dbservername"];
            $this -> userName =   $myArray["dbusername"];
            $this -> password = $myArray["dbpassword"];

    }
}
?>