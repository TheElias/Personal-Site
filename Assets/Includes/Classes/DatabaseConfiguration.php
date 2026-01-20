<?php
namespace Site;

class DatabaseConfiguration {

    private string $serverName;
    private string $databaseName;
    private string $username;
    private string $password;
    private int $port;

    public function __construct(array $overrides = [])
    {
        $this->serverName = getenv('DB_HOST') ?: '127.0.0.1';
        $this->databaseName = getenv('DB_NAME') ?: '';
        $this->username = getenv('DB_USER') ?: '';
        $this->password = getenv('DB_PASS') ?: '';
        $this->port = (int)(getenv('DB_PORT') ?: 3306);
    }
        
    public function getDsn(): string {
        return sprintf(
                       'mysql:host=%s;dbname=%s;charset=utf8mb4', 
                       $this->serverName, 
                       $this->databaseName,
                      );
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    // Keep these for backwards compatibility with existing code
    public function getServerName(): string {
        return $this->serverName;
    }

    public function getDatabaseName(): string {
        return $this->databaseName;
    }

    public function getPort(): int {
        return $this->port;
    }
}