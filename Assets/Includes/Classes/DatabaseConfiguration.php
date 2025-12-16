<?php

    namespace Site;

class DatabaseConfiguration {
    protected $serverName;
    protected $userName;
    protected $password;
    protected $databaseName;    

    function __construct(array $overrides = []) {
        $this->serverName   = $overrides['dbservername']   ?? Config::get('dbservername', '127.0.0.1');
        $this->databaseName = $overrides['personal_website']   ?? Config::get('personal_website', '');
        $this->userName     = $overrides['dbusername']   ?? Config::get('dbusername', '');
        $this->password     = $overrides['dbpassword']   ?? Config::get('dbpassword', '');

    }

    public function getDsn(): string {
        return sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $this->serverName, $this->databaseName);
    }

    public function getUsername(): string {
        return $this->userName;
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
}