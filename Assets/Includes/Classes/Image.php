<?php
        require_once './Assets/Includes/Classes/Database.php';
        require_once './Assets/Includes/Classes/Interfaces/iImage.php';

    class Image implements iImage 
    {
        protected $database;
        protected $conn;
        protected $id;
        protected $url;
        protected $name;
        protected $fileName;

        function __construct()
        {   
            $this->database = new Database();
            $this->database->connect();

            $this->conn = $this->database->getConnection();
        }

        public function loadImageByID($id)
        {
            $sql = "SELECT *
            FROM personal_website.image
            WHERE id =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$id]);
            $imageInfo = $result -> fetch();  
            
            if (!$imageInfo) {
                return false;
            }
            
            $this->id = $id;
            $this->name = $imageInfo['name'];
            $this->url = $imageInfo['URL'];
            $this->fileName = $imageInfo['file_name'];

            return true;
        }

        public function loadImageByName($name)
        {
            $sql = "SELECT *
            FROM personal_website.image
            WHERE name =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$name]);
            $imageInfo = $result -> fetch();  
            
            if (!$imageInfo) {
                return false;
            }
            
            $this->id = $imageInfo['id'];
            $this->name = $name;
            $this->url = $imageInfo['URL'];
            $this->fileName = $imageInfo['file_name'];
            return true;
        }

        public function loadImageByFileName($fileName)
        {
            $sql = "SELECT *
            FROM personal_website.image
            WHERE file_name =  ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$fileName]);
            $imageInfo = $result -> fetch();  
            
            if (!$imageInfo) {
                return false;
            }
            
            $this->id = $imageInfo['id'];
            $this->name = $imageInfo['name'];
            $this->url = $imageInfo['URL'];
            $this->fileName = $fileName;
            return true;
        }
    
        public function getID()
        {
            if (empty($this->id))
            {
                return false;
            }
            return $this->id; 
        }

        public function getName()
        {
            if (empty($this->name))
            {
                return false;
            }
            return $this->name; 
        }

        public function getFileName()
        {
            if (empty($this->fileName))
            {
                return false;
            }
            return $this->fileName; 
        }

        public function getURL()
        {
            if (empty($this->url))
            {
                return false;
            }
            return $this->url; 
        }

        public function getFullFileLocation()
        {
            if (empty($this->fileName) || empty($this->url))
            {
                return false;
            }
            return '../' . $this->url . $this->fileName; 
        }
    
        public static function doesImageExist($id)
        {
            $myImage = New Image;
            return( $myImage->loadImageByID($id));
        }

        public static function verifyFileLocation($fullFilePath)
        {
            file_exists($fullFilePath);
        } 
    
        //check if file exists in the location and then save the database object
        public static function saveNewImage($name, $url, $fileName)
        {
            return false;
        }
        
        public static function updateImage($id, $name, $fileName, $url)
        {
            return false;
        }
    
        public static function fetchImageFileLocation($id)
        {
            if (!Image::doesImageExist($id))
            {
                return false;
            }

            $myImage = new Image;
            $myImage->loadImageByID($id);

            if (!$myImage)
            {
                return false;
            }

            return $myImage->getFullFileLocation();
        }
    }
?>