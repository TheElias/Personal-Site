<?php
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Database.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Interfaces/iImage.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/Interfaces/iFileEdit.php';

define('allowedImageExtensions', ["jpeg","jpg","png, svg"]);

    class Image implements iImage 
    {
        protected $database;
        protected $conn;
        protected $id;
        protected $url;
        protected $name;
        protected $fileName;
        protected $imageTypeID;
        protected $imageTypeName;
        
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

        public function loadImageByBlogPostIDAndImageType($blogPostID,$typeName)
        {
            $sql = "SELECT I.id, I.name, I.URL, I.file_name
                    FROM blog_post AS BP
                    INNER JOIN blog_post_image AS BPI ON BP.id = BPI.blog_post_id 
                    INNER JOIN image AS I ON BPI.image_id = I.id
                    INNER JOIN image_type as IT ON IT.id = I.image_type_id
                    WHERE BP.id = ? AND IT.name = ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$blogPostID,$typeName]);
            $imageInfo = $result -> fetch();  
            
            if (!$imageInfo) {
                return false;
            }
            
            $this->id = $imageInfo['id'];
            $this->name = $imageInfo['name'];
            $this->url = $imageInfo['URL'];
            $this->fileName = $imageInfo['file_name'];
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

        public function getImageTypeID()
        {
            if (empty($this->imageTypeID))
            {
                return false;
            }
            return $this->imageTypeID; 
        }
        public function getImageTypeName()
        {
            if (empty($this->imageTypeName))
            {
                return false;
            }
            return $this->imageTypeName; 
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
                    image.URL, image_type.name as imageTypeName
                    FROM personal_website.image 
                    LEFT JOIN personal_website.image_type ON image.image_type_id = image_type.id";

            $result = $conn->prepare($sql);
            $result->execute();

            $imageList= $result->fetchAll(PDO::FETCH_ASSOC); 
            
            if (!$imageList) {
                return false;
            }
            
            return $imageList;
        }


        public static function getImageTypeInfoByName($name)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT *
                    FROM personal_website.image_type AS IT
                    WHERE IT.name =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$name]);
            $imageTypeInfo = $result -> fetch();  
            
            if (!$imageTypeInfo) {
                return false;
            }
            
            return $imageTypeInfo;
        }

        public static function getImageTypeInfoByID($id)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT *
                    FROM personal_website.image_type AS IT
                    WHERE IT.id =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$id]);
            $imageTypeInfo = $result -> fetch();  
            
            if (!$imageTypeInfo) {
                return false;
            }
            
            return $imageTypeInfo;
        }

        public static function getImageTypeIDByName($name)
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT id
                    FROM personal_website.image_type AS IT
                    WHERE IT.name =  ?";

            $result = $conn->prepare($sql);
            $result->execute([$name]);
            $imageTypeInfo = $result -> fetch();  
            
            if (!$imageTypeInfo) {
                return false;
            }
            
            return $imageTypeInfo['id'];
        }

        public static function getImageTypeNameByID($id)
        {
            $myImage = New Image;
            $myImage->loadImageByID($id);
            return $myImage->getImageTypeName();
        }

        public static function fetchAllImageTypes()
        {
            $myDB = new Database();
            $myDB->connect();
            $conn = $myDB->getConnection();
            
            $sql = "SELECT id, name
                    FROM personal_website.image_type AS IT
                    WHERE is_disabled =  False
                    ORDER BY name";

            $result = $conn->prepare($sql);
            $result->execute();
            $imageTypeInfo = $result->fetchAll(PDO::FETCH_ASSOC); 
            
            if (!$imageTypeInfo) {
                return false;
            }
            
            return $imageTypeInfo;
        }

        public static function saveNewImageFromObject($image, $userFriendlyName, $imageType = "General", $destinationFileName, $destinationPath = '')
        {
            //check if image type exists
            $myImageType = Image::getImageTypeInfoByName($imageType);
            
            if ($myImageType == false)
            {
                return false;
            }
            
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
            if (!in_array(pathinfo($image['name'],PATHINFO_EXTENSION),   allowedImageExtensions))
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
                $sql = "INSERT INTO  personal_website.image (name, file_name, URL, image_type_id)
                    VALUES (?,?,?,?)";

                $result = $conn->prepare($sql);
                echo "<br /> User Friendly Name: " . $userFriendlyName,"<br /> Destination Name: "  . $destinationFileName,"<br /> Default Save Location: " . $myImageType['default_save_location'],"<br /> Image Type ID: " . $myImageType['id'] . "<br />";

                $result->execute([$userFriendlyName,$destinationFileName, $myImageType['default_save_location'],$myImageType['id'] ]);
                
                   
                if ($result->rowCount() == 0)
                {
                    return false;
                }
                
                return true;
            }
            echo '<br /> Fail Upload <br /> ';
            return false;
        }

        public static function saveNewImageFromPath($destinationFileName,$userFriendlyName,  $imageType = "General", $url, $fileName, $destinationPath = '')
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
    }
?>