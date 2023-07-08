<?php

use PHPUnit\Framework\TestCase;

include('./Assets/Includes/Classes/Database.php');

class BackendTest extends TestCase 
{
    public function testDatabaseConnection()    
    {
        $testDatabase = new Database();
        $testDatabase->Database();
        $testDatabase->connect();
        $this->assertInstanceOf(\PDO::class,$testDatabase->getConnection());
        //$this->expectException("Database Connection Failed");
    }

    public function testDatabaseConnectOnUninitializedDatabaseClass()    
    {
        $testDatabase = new Database();
        $this->expectException(Exception::class);
        $testDatabase->connect();
    }

    public function testDatabaseSelectTableDoesNotExist()
    {
        
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
