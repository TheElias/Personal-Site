<?php

interface iUser {

    public function loadUserByUsername($username);
    public function loadUserByID($id);

    public function getID();
    public function getFirstName();
    public function getLastName();
    public function getFullName();
    public function getDateOfBirth();
    public function getJoinedDate();

    public function getUsername();
    public function getPassword();
   
    

    public static function checkCredentials(); 
    public static function doesUserExistByID($id);
    public static function doesUserExistByUsername($name);
   
    public static function getUsersBlogPosts($id);
}

?>