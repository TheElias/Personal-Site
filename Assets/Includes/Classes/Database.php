<?php 

    namespace Site;

    use PDO;
    use PDOException;
    use Exception;

    class Database
    {
        private ?PDO $connection = null;
        private DatabaseConfiguration $config;

        function __construct(?DatabaseConfiguration $config = null)
        {
            $this->config = $config ?? new DatabaseConfiguration();
        }

        public function connect()
        {
            try 
            {    
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=utf8mb4',
                    $this->config->getServerName(),
                    $this->config->getDatabaseName()
                );

                $this->connection = new PDO(
                    $dsn,
                    $this->config->getUsername(), 
                    $this->config->getPassword(),
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]);

                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo 'Database->Connect: mysql:host='  . $this -> serverName . ';dbname='. $this -> databaseName . " " . $this -> userName . " " .  $this -> password;
            }
            catch(PDOException $e)
            {
                throw new Exception("Database Connection Failed. " . $e->getMessage());
                return false; 
            }

            return true;
        }

        public function getConnection(): PDO
        {
           return $this->connection;
        }
    
        public function disconnect() {
            $this -> connection = NULL;
        }
    }
?>