<?php

namespace Site\Interfaces;

interface iAuthor {

    public function loadAuthorByID($ID);
    public function loadAuthorByUsername($username);

    public function getID();
    public function getFirstName();
    public function getLastName();
    public function getFullName();
    public function getUsername();
    public function getDateOfBirth();

    public static function doesAuthorExist($id);
   
    public static function getAuthorsBlogPosts($id);

}

?>