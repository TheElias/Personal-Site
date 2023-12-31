
<?php

require_once './Assets/Includes/Classes/Interfaces/iFileEdit.php';

class FileEdit implements iFileEdit 
    {
        protected $sourceLocation;
        protected $destinationLocation;
        protected $sourceFileName;
        protected $fileSaveName = '';
        protected $uploadFileName;
        protected $fileToUpload;

        
        function __construct()
        {   
        }

        public function setSourceFileDirectory($sourceLocation)
        {
            $this->sourceLocation = $sourceLocation;
        }
        
        public function setDestination($destinationLocation = "/var/www/eliasbroniecki.com/html/images/")
        {
            $this->destinationLocation = $destinationLocation;
        }

        public function setsourceFileName($fileName)
        {
            $this->sourceFileName = $fileName;
        }

        public function setFileSaveName($fileName)
        {
            $this->fileSaveName = $fileName;
        }

        public function setFileToUpload($fileToUpload)
        {
            $this->fileToUpload = $fileToUpload;
        }

        public function getSource()
        {
            return $this->sourceLocation;
        }
        public function getDestination()
        {
            return $this->destinationLocation;
        }

        public function getFileSaveName()
        {
            return $this->fileSaveName;
        }

        public function uploadFileFromPath()
        {
            if (!FileEdit::doesDirectoryExist($this->destinationLocation) || !FileEdit::doesFileExist($this->sourceFileName,$this->sourceLocation)) 
            {
                return false;
            }

            if (move_uploaded_file($this->fileToUpload, $this->destinationLocation))
            {
                if ($this->sourceFileName != $this->fileSaveName)
                {
                    if (!FileEdit::updateFileName($this->fileSaveName, $this->sourceFileName,$this->destinationLocation ))
                    {
                        return false;
                    }
                }
                return true;
            }
            return false;
        }

        public function uploadFileFromObject()
        {
            if (!FileEdit::doesDirectoryExist($this->destinationLocation) || get_resource_type($this->fileToUpload ) != "file") 
            {
                return false;
            }

            if (move_uploaded_file($this->sourceFileName,$this->sourceLocation, $this->destinationLocation))
            {
                if ($this->sourceFileName != $this->fileSaveName)
                {
                    if (!FileEdit::updateFileName($this->fileSaveName, $this->sourceFileName,$this->destinationLocation ))
                    {
                        return false;
                    }
                }
                return true;
            }
            return false;
        }
    
        public static function doesFileExist($fileName, $fileLocation = "/var/www/eliasbroniecki.com/html/images/")
        {

            if (is_file($fileLocation . $fileName))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function doesDirectoryExist($directory)
        {
            if (is_dir($directory))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function downloadFile($fileName, $fileLocation = "/var/www/eliasbroniecki.com/html/images/")
        {

            $file_url = $fileLocation & $fileName;
            if (!FileEdit::doesFileExist($file_url))
            {
                return false;
            }
 
            header('Content-Type: application/octet-stream');  
            header("Content-Transfer-Encoding: Binary");   
            header("Content-disposition: attachment; filename=\"" . basename($file_url) );   //. "\""
            readfile($file_url);  

        }

        public static function getListOfFiles($fileLocation= "/var/www/eliasbroniecki.com/html/images/")
        {

        }
        public static function updateFileName($newFileName, $fileName, $fileLocation = "/var/www/eliasbroniecki.com/html/images/")
        {

        }
    }

?>