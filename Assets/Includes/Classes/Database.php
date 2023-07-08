<?php 
    include('./Assets/Includes/Classes/DatabaseConfiguration.php');

    class Database extends DatabaseConfiguration
    {
        public $connection;
        public $recordset;
        private $sqlQuery;

        protected $serverName;
        protected $userName;
        protected $password;
        protected $databaseName;

        function Database () {
            $this -> connection = NULL;
            $this -> sqlQuery = NULL;
            $this -> recordset = NULL;

            $databaseParameters = new DatabaseConfiguration();
            $databaseParameters->DatabaseConfiguration();
            $this -> databaseName = $databaseParameters -> databaseName;
            $this -> serverName = $databaseParameters -> serverName;
            $this -> userName = $databaseParameters -> userName;
            $this -> password = $databaseParameters ->password;
        }

        public function connect()
        {
            try 
            {    
                $this->connection = new PDO('mysql:host='  . $this->serverName . ';dbname='.$this->databaseName, $this->userName, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Hi: mysql:host='  . $this -> serverName . ';dbname='. $this -> databaseName . " " . $this -> userName . " " .  $this -> password;
            }
            catch(PDOException $e)
            {
                throw new Exception("Database Connection Failed. " . $e->getMessage() . ". " . ' mysql:host='  . 
                        $this -> serverName . ';dbname='. $this -> databaseName . " " . $this -> userName . " " .  $this -> password);
            }

            return $this;
        }

        public function getConnection(): PDO
        {
           return $this->connection;
        }

        
        function selectAll($tableName)  
        {
            $sql = 'SELECT * FROM '.$this -> databaseName.'.'.$tableName;

            $result = $this->connection->prepare($sql);
            $result->execute();
            return $result -> fetchAll(PDO::FETCH_ASSOC);
            // $blogPost = $result -> fetch();  
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