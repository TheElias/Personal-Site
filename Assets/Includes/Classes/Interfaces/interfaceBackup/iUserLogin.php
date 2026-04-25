<?php

namespace Site\Interfaces;

interface iUserLogin {

   public function login($username = '', $password = '', $remember = 0);
   
   //public function logout();

   public function createNewUser($username= '', $password = '', $email = '', $firstName, $lastName, $DOB = '');

   //public function isLoggedIn();
   //public function isPendingLevel();
   //public function isUserLevel();
   //public function isAuthorLevel();
   //public function isModeratorLevel();
   //public function isAdministratorLevel();

   public static function checkUserSessionLogin();

   public static function doesUserExistByUsername($username);
   public static function doesUserExistByEmail($email);

   public static function clearUserCookies();



}

?>