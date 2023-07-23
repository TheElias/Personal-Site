<?php

use PHPUnit\Framework\TestCase;

include('./Assets/Includes/Classes/Database.php');

class BackendTest extends TestCase 
{
    public function getHomeCredentials()
    {
        return array("DbName"=>'personal_website', "ServerName"=>'eliasbroniecki.com',"Username"=>'eliasTest',"Password"=>'Passw0rd1');
    }
    public function testDatabaseConnection()    
    {
        $testDatabase = new Database();
        $connectionItems = $this->getHomeCredentials();
        $testDatabase->setCredentials($connectionItems["DBName"],$connectionItems["ServerName"],$connectionItems["Username"],$connectionItems["Password"]);
        $testDatabase->connect();
        $this->assertInstanceOf(\PDO::class,$testDatabase->getConnection());
    }

    public function testDatabaseConnectOnUninitializedDatabaseClass()    
    {
        $testDatabase = new Database();
        $this->expectException(Exception::class);
        $testDatabase->connect();
    }

    
    public function testDatabaseConnectOnBadCredentials()    
    {
        $testDatabase = new Database();
        $this->expectException(Exception::class);
        $connectionItems = $this->getHomeCredentials();
        $testDatabase->setCredentials($connectionItems["DBName"],$connectionItems["ServerName"],$connectionItems["Username"],$connectionItems["Password"]);
        $testDatabase->connect();
    }

    public function testDatabaseSelectTableDoesNotExist()
    {
        $testDatabase = new Database();
        $testDatabase->Database();
        $testDatabase->connect();
        $this->expectException(PDOException::class);
        $mydata = $testDatabase->selectAll("blog_postss");
    }

    public function testSelectAllWorks()
    {
        $testDatabase = new Database();
        $testDatabase->Database();
        $testDatabase->connect();
        $mydata = $testDatabase->selectAll("blog_post");
        $this->assertIsArray($mydata);
    }
}

/*
    public function testFetchBlogID()    {
        $this->markTestIncomplete( 'Not written yet.' );
    }

    public function testInsert()
    {
        $this->markTestIncomplete( 'Not written yet.' );
    }

    public function testUpdate()
    {
        $this->markTestIncomplete( 'Not written yet.' );
    }

    public function testDelete()
    {
        $this->markTestIncomplete( 'Not written yet.' );
    }
*/
?>
