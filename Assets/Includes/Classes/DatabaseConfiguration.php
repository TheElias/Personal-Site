<?php

require_once("./Assets/Includes/generalFunctions.php");



class DatabaseConfiguration {
    protected $serverName;
    protected $userName;
    protected $password;
    protected $databaseName;    

    function __construct()
    {
        if(file_exists("X:\Projects\PersonalSite\EliasBroniecki.com\Code\ignoredFiles\config.env"))
        {
            $myFile = file_get_contents("X:\Projects\PersonalSite\EliasBroniecki.com\Code\ignoredFiles\config.env");
            $myArray = parse_env_file_contents_to_array($myFile);
            //echo  "TEST dbname: " . $myArray["dbname"] . "  Server Name: " . $myArray["servername"] . " Username: " . $myArray["username"] . " password" . $myArray["dbpassword"];
        }
        else
        {
            $myFile = file_get_contents('/var/www/config/config.env');

            $myArray = parse_env_file_contents_to_array($myFile);
        }

            $this -> databaseName = $myArray["dbname"];
            $this -> serverName = $myArray["dbservername"];
            $this -> userName =   $myArray["dbusername"];
            $this -> password = $myArray["dbpassword"];

    }
}
?>