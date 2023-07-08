<?php
class DatabaseConfiguration {
    protected $serverName;
    protected $userName;
    protected $password;
    protected $databaseName;

    function DatabaseConfiguration() {
        $this -> databaseName = 'personal_website';
        $this -> serverName = 'eliasbroniecki.com';
        $this -> userName = 'eliasTest';
        $this -> password = 'Passw0rd1';
    }
}
?>