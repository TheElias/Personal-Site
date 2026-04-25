
<?php

    namespace Site;
   
    use Site\Interfaces\iFileEdit;

class FileEdit implements iFileEdit 
    {
        protected $destinationLocation;
        protected $fileSaveName = '';
        protected $file;

        
        function __construct()
        {   
        }
        
        public function setDestination($destinationLocation = "/var/www/eliasbroniecki.com/html/images/")
        {
            $this->destinationLocation = $destinationLocation;
        }

        public function setFileSaveName($fileName)
        {
            $this->fileSaveName = $fileName;
        }

        public function setFileToUpload($file)
        {
            $this->file= $file;
        }

        public function getDestination()
        {
            return $this->destinationLocation;
        }

        public function getFileSaveName()
        {
            return $this->fileSaveName;
        }


        public function uploadFile()
        {
            if (!FileEdit::doesDirectoryExist($this->destinationLocation)) 
            {
                return false;
            }

            //echo '<br /> upload - File temp name:  ' . $this->file['tmp_name'] . "  Destination: " .  $this->destinationLocation . (($this->fileSaveName == "")  ? $this->file['tmp_name'] : $this->fileSaveName) . '<br /> ';
            if (move_uploaded_file($this->file['tmp_name'], $this->destinationLocation . (($this->fileSaveName == "")  ? $this->file['tmp_name'] : $this->fileSaveName) ))
            {
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
            return rename($fileLocation . $fileName, $newFileName);
        }
    }

?>