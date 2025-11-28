<?php
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Database.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Interfaces/iImage.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/FileEdit.php';

define('allowedImageExtensions', ["jpeg","jpg","png", "svg"]);
//define('defaultImageSaveLocation', '../' . $this->url);

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

        public static function doesImageExistByName($name)
        {
            $myImage = New Image;
            return( $myImage->loadImageByName($name));
        }

        public static function doesImageExistByFileName($filename)
        {
            $myImage = New Image;
            return( $myImage->loadImageByFileName($filename));
        }

        public static function verifyFileLocation($fullFilePath)
        {
            file_exists($fullFilePath);
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

        public static function fetchImageList()
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $sql = "SELECT image.id as ImageID, image.name as imageName, image.file_name as imageFileName, 
                    image.URL
                    FROM personal_website.image ";

            $result = $conn->prepare($sql);
            $result->execute();

            $imageList= $result->fetchAll(PDO::FETCH_ASSOC); 
            
            if (!$imageList) {
                return false;
            }
            
            return $imageList;
        }

        public static function saveNewImageFromObject($image, $userFriendlyName, $destinationFileName, $destinationPath = '')
        {            
            //check if image exists with that name already in DB
            if (Image::doesImageExistByName($userFriendlyName))
            {
                return false;
            }
           
            //Check if the file exists already in the database
            if (Image::doesImageExistByFileName($destinationFileName))
            {
                return false;
            }

            echo pathinfo($image['name'],PATHINFO_EXTENSION);
            if (!in_array(pathinfo(strtolower($image['name']),PATHINFO_EXTENSION),   allowedImageExtensions,true))
            {
                return false;
            }

            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();

            $myImage = new FileEdit();
            echo '<br /> setDestination <br /> ';
            $myImage->setDestination();

            echo '<br /> setFileSaveName <br /> ';
            $myImage->setFileSaveName($destinationFileName);

            echo '<br /> setFileToUpload <br /> ';
            $myImage->setFileToUpload($image);
            
            if ($myImage->uploadFile())
            {
                echo '<br /> Insert Into Database <br /> ';
                $sql = "INSERT INTO  personal_website.image (name, file_name, URL)
                    VALUES (?,?,?)";

                $result = $conn->prepare($sql);
                echo "<br /> User Friendly Name: " . $userFriendlyName,"<br /> Destination Name: "  . $destinationFileName,"<br />";

                $result->execute([$userFriendlyName,$destinationFileName, $_SERVER['REQUEST_URI']]  );//defaultImageSaveLocation]  );
                
                   
                if ($result->rowCount() == 0)
                {
                    return false;
                }
                
                return true;
            }
            echo '<br /> Fail Upload <br /> ';
            return false;
        }

        public static function saveNewImageFromPath($destinationFileName,$userFriendlyName, $url, $fileName, $destinationPath = '')
        {
            $myImage = new FileEdit();
            $myImage->setDestination();

            //$myImage->setSourceFileDirectory($name);

            return false;
        }
        
        public static function updateImageInfo($id, $name, $fileName, $url)
        {
            return false;
        }

        function createThumbnail($srcPath, $destPath, $thumbWidth = 300) {
            $info = getimagesize($srcPath);
            if (!$info) return false;
        
            $mime = $info['mime'];
            list($width, $height) = $info;
        
            switch ($mime) {
                case 'image/jpeg': $srcImage = imagecreatefromjpeg($srcPath); break;
                case 'image/png':  $srcImage = imagecreatefrompng($srcPath); break;
                case 'image/gif':  $srcImage = imagecreatefromgif($srcPath); break;
                default: return false;
            }
        
            $thumbHeight = floor($height * ($thumbWidth / $width));
            $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
        
            imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
        
            switch ($mime) {
                case 'image/jpeg': imagejpeg($thumbImage, $destPath, 85); break;
                case 'image/png':  imagepng($thumbImage, $destPath); break;
                case 'image/gif':  imagegif($thumbImage, $destPath); break;
            }
        
            imagedestroy($srcImage);
            imagedestroy($thumbImage);
            return true;
        }
    }



?>