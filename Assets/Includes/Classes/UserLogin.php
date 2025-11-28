<?php

    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Database.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Interfaces/iUserLogin.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/TokenAuth.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Config.php';

    //The various user levels
    const LEVEL_PENDING 	= 0; //User is still pending email confirmation
    const LEVEL_USER 		= 1; //Standard user with normal privileges
    const LEVEL_AUTHOR 		= 2; //Standard user with author privileges
    const LEVEL_MODERATOR 	= 3; //Special case users with higher privileges
    const LEVEL_ADMIN 		= 4; //Administrators with all privileges

    class UserLogin extends TokenAuth implements iUserLogin 
    {
        protected $database;
        protected $conn;

        public $userInfo;

        public $loggedIn = false;
        private $userLevel = 0;

        private $errors = [];

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn = $this->database->getConnection();
        }

        public function login($username = '', $password = '', $remember = 0)
        {
            $isAuthenticated = false;

            if( !strlen( $username ) )
            {
                $this->errors[] = 'No username was submitted!';
                return FALSE;
            }
            
            if( !strlen( $password ) )
            {
                $this->errors[] = 'No password was submitted!';
                return FALSE;
            }

            if (!UserLogin::doesUserExistByUsername($username))
            {
                $this->errors[] = 'Username  \''. $username.'\' could not be found.';
			    return FALSE;
            }

            $sql = "SELECT *
            FROM personal_website.user AS U
            WHERE U.username =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$username]);
            $userInfo = $result -> fetch();  

            if (password_verify($password, $userInfo['password']))
            {
                $isAuthenticated = true;
            }
            
            if ($isAuthenticated)
            {
                // Get Current date, time
                $current_time = time();

                // Set Cookie expiration for 1 month
                $loginCookieExpirationTime = $current_time + (30 * 24 * 60 * 60);  // for 1 month

                // Get cookie domain from config
                $cookieDomain = Config::get('COOKIE_DOMAIN', 'localhost');

                $cookieOpts = [
                    'expires' => $loginCookieExpirationTime,
                    'path' => '/',
                    'domain' => $cookieDomain,
                    'secure' => true,            // only over HTTPS
                    'httponly' => true,          // inaccessible to JS
                    'samesite' => 'Lax',         // or 'Strict' based on needs
                ];

                // Set Auth Cookies if 'Remember Me' checked. 
                if ($remember) {
                    setcookie("username", $username, $cookieOpts);

                    //Bin 2 hex used to eliminate the chance of null or control characters in the cookie values
                    $random_password = bin2hex(random_bytes(16));
                    setcookie("random_password", $random_password, $cookieOpts);
                    
                    $random_selector = bin2hex(random_bytes(32));
                    setcookie("random_selector", $random_selector, $cookieOpts);
                    
                    $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
                    $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
                    
                    $expiry_date = date("Y-m-d H:i:s", $loginCookieExpirationTime);
                    
                    // mark existing token as expired
                    $userToken = TokenAuth::getTokenByUsername($username,0);

                    if (! empty($userToken["id"])) 
                    {
                        TokenAuth::markTokenAsExpired($userToken["id"]);
                    }
                    // Insert new token
                    TokenAuth::insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
                } 
                else 
                {
                    UserLogin::clearUserCookies();
                }

                $this->userInfo = $userInfo; 
                $_SESSION['username'] = $username;
                $this->loggedIn = true;
                return true;
  
            }
            else 
            {
                $this->errors[] = 'Password was incorrect.';
			    return FALSE;	
            }
        }

        public static function checkUserSessionLogin()
        {
            $current_time = time();
            $current_date = date("Y-m-d H:i:s", $current_time);

            if (! empty($_SESSION["username"])) {
                return true;
            }

            if (! empty($_COOKIE["username"]) && ! empty($_COOKIE["random_password"]) && ! empty($_COOKIE["random_selector"])) 
            {
                // Initiate auth token verification diirective to false
                $isPasswordVerified = false;
                $isSelectorVerified = false;
                $isExpiryDateVerified = false;
                
                // Get token for username
                $userToken = TokenAuth::getTokenByUsername($_COOKIE["username"],0);
                
                // Validate random password cookie with database
                if (password_verify($_COOKIE["random_password"], $userToken["password_hash"])) {
                    $isPasswordVerified = true;
                }
                
                // Validate random selector cookie with database
                if (password_verify($_COOKIE["random_selector"], $userToken["selector_hash"])) {
                    $isSelectorVerified = true;
                }
                
                // check cookie expiration by date
                if($userToken["expiry_date"] >= $current_date) {
                    $isExpiryDateVerified = true;
                }
                
                // Redirect if all cookie based validation retuens true
                // Else, mark the token as expired and clear cookies
                if (!empty($userToken["id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) 
                {
                    $_SESSION['username'] = $_COOKIE["username"];
                    return true;
                } else {
                    if(!empty($userToken["id"])) {
                        TokenAuth::markTokenAsExpired($userToken["id"]);
                    }
                    // clear cookies
                    UserLogin::clearUserCookies();
                }
            }
            return false;
        }

        public function logout()
        {
            $this->loggedIn = false;
            session_destroy();
        }
     
        public function createNewUser($username= '', $password = '', $firstName='', $lastName='', $DOB = '', $email = '')
        {
            if( !strlen( $username ) )
            {
                $this->errors[] = 'No username was submitted!';
                return FALSE;
            }
            
            if( !strlen( $password ) )
            {
                $this->errors[] = 'No password was submitted!';
                return FALSE;
            }

            if( !strlen( $firstName ) )
            {
                $this->errors[] = 'No first name was submitted!';
                return FALSE;
            }

            if( !strlen( $lastName ) )
            {
                $this->errors[] = 'No last name was submitted!';
                return FALSE;
            }
            if( !strlen(!$email ) )
            {
                if (!filter_var($email,FILTER_VALIDATE_EMAIL))
                {
                    $this->errors[] = 'Invalid Email Format!';
                    return FALSE;
                }
                
                if (UserLogin::doesUserExistByEmail($email))
                {
                    $this->errors[] = 'Username already exists!';
                    return FALSE;
                }
            }
            if (UserLogin::doesUserExistByUsername($username))
            {
                $this->errors[] = 'Username already exists!';
                return FALSE;
            }
            

            $sql = "INSERT INTO  personal_website.user (first_name, last_name, username, password)
                    VALUES (?,?,?,?)";

            $result = $this->conn->prepare($sql);
            $result->execute([$firstName,$lastName, $username, password_hash($password,PASSWORD_DEFAULT)]);
            $userInfo = $result -> fetch();  
            
            if (!$userInfo)
            {
                return false;
            }
            
            return $userInfo;

        }
     
        public function isLoggedIn()
        {
            return $this->loggedIn;	
        }
     
        public static function doesUserExistByUsername($username = '')
        {
            if( !$username )
            {
			    return FALSE;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT *
            FROM personal_website.user 
            WHERE username =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$username]);
            
            if ($result->rowCount() >0)
            {
                return true;
            }
            return false;
        }
        public static function doesUserExistByEmail($email = '')
        {
            if( !$email )
            {
			    return FALSE;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT *
            FROM personal_website.user 
            WHERE email =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$email]);
            
            if ($result->rowCount() >0)
            {
                return true;
            }
            return false;
        }

        function get_last_error( $echo = false )
        {
            if( $echo )
                echo $this->errors[count($this->errors)-1];
            else
                return $this->errors[count($this->errors)-1];
        }

        public static function clearUserCookies()
        {
            $cookieDomain = Config::get('COOKIE_DOMAIN', 'localhost');
            $clearOpts = [
                'expires' => time() - 1000,
                'path' => '/',
                'domain' => $cookieDomain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax',
            ];
            if (isset($_COOKIE["username"])) {
                setcookie("username", "", $clearOpts);
            }
            if (isset($_COOKIE["random_password"])) {
                setcookie("random_password", "", $clearOpts);
            }
            if (isset($_COOKIE["random_selector"])) {
                setcookie("random_selector", "", $clearOpts);
            }
        }

    }
?>