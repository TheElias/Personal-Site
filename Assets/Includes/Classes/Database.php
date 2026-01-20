<?php
declare(strict_types=1);

namespace Site;

    use PDO;
    use PDOException;
    use Exception;

    class Database
    {
        private ?PDO $connection = null;
        private DatabaseConfiguration $config;

        function __construct(?DatabaseConfiguration $config)
        {
            $this->config = $config ?? new DatabaseConfiguration();
        }
        
        public static function fromEnvironment(array $overrides = []): Database
        {
            $config = new DatabaseConfiguration($overrides);
            var_dump($config->getDsn(), $config->getUsername(), $config->getPassword(),$config->getPort());
            return new Database($config);
        }

        public function connect()
        {
            try 
            {    
                $this->connection = new PDO(
                    $this->config->getDsn(),
                    $this->config->getUsername(), 
                    $this->config->getPassword(),
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]);
                //echo 'Database->Connect: mysql:host='  . $this -> serverName . ';dbname='. $this -> databaseName . " " . $this -> userName . " " .  $this -> password;
            }
            catch(PDOException $e)
            {
                throw new Exception("Database connection failed", 0, $e);
                return false;
            }

            return true;
        }

        public function getConnection(): PDO
        {
           if ($this->connection === null) {
                $this->connect();
            }
    return $this->connection;
        }
    
        public function disconnect() {
            $this -> connection = null;
        }
    }
?>