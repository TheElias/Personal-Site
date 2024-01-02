<?php 
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/Assets/Includes/Classes/DatabaseConfiguration.php';

    class Database extends DatabaseConfiguration
    {
        public $connection;
        public $recordset;
        private $sqlQuery;

        protected $serverName;
        protected $userName;
        protected $password;
        protected $databaseName;

        function __construct()
        {
            $databaseParameters = new DatabaseConfiguration();
            $this->databaseName = $databaseParameters->databaseName;
            $this->serverName = $databaseParameters->serverName;
            $this->userName = $databaseParameters->userName;
            $this->password = $databaseParameters->password;
        }

        function setCredentials($myDatabaseName,$myServerName, $myUsername, $myPassword) 
        {
            $this->databaseName = $myDatabaseName;
            $this->serverName = $myServerName;
            $this->userName = $myUsername;
            $this->password = $myPassword;
        }

        public function connect()
        {
            try 
            {    
                $this->connection = new PDO('mysql:host='  . $this->serverName . ';dbname='.$this->databaseName, $this->userName, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo 'Database->Connect: mysql:host='  . $this -> serverName . ';dbname='. $this -> databaseName . " " . $this -> userName . " " .  $this -> password;
            }
            catch(PDOException $e)
            {
                throw new Exception("Database Connection Failed. " . $e->getMessage() . ". " . ' mysql:host='  . 
                        $this -> serverName . ';dbname='. $this -> databaseName . " " . $this -> userName . " " .  $this -> password);
                return false; 
            }

            return true;
        }

        public function getConnection(): PDO
        {
           return $this->connection;
        }
        
        public function selectAll($tableName)  
        {
            $sql = 'SELECT * FROM '. $this->databaseName.'.'.$tableName;
            $result = $this->connection->prepare($sql);
            $result->execute();
            return $result -> fetchAll(PDO::FETCH_ASSOC);
        }

        function fetch($query)
        {
            
            $result = $this->connection->prepare($query);
            $result->execute();
           
             $result -> fetchAll(PDO::FETCH_ASSOC);
             
             return $result;
        }
    
        public function disconnect() {
            $this -> connection = NULL;
            $this -> sqlQuery = NULL;
            $this -> recordset = NULL;
            $this -> databaseName = NULL;
            $this -> serverName = NULL;
            $this -> userName = NULL;
            $this -> password = NULL;
        }
    }
?>