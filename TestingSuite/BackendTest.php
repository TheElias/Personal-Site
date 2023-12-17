<?php

use PHPUnit\Framework\TestCase;

require_once './Assets/Includes/Classes/Database.php';
require_once './Assets/Includes/Classes/DatabaseConfiguration.php';
require_once './Assets/Includes/Classes/BlogPostTag.php';

class BackendTest extends TestCase 
{
    /*===========================
    DATABASE TESTING
    ===========================*/
    
    public function testDatabaseGetConnection()    
    {
        $testDatabase = new Database();
        $testDatabase->connect();
        $this->assertInstanceOf(\PDO::class, $testDatabase->getConnection());
    }
    
    public function testDatabaseSelectTableDoesNotExist()
    {
        $testDatabase = new Database();
        $testDatabase->connect();
        $this->expectException(PDOException::class);
        $mydata = $testDatabase->selectAll("blog_postss");
    }

    public function testSelectAllWorks()
    {
        $testDatabase = new Database();
        $testDatabase->connect();
        $mydata = $testDatabase->selectAll("blog_post");
        $this->assertIsArray($mydata);
    }
    /*===========================
    TAG TESTING
    ===========================*/

    public function testDoesTagExist()
    {
        $this->assertTrue(BlogPostTag::doesTagExistByName("Introduction"));
    }

    public function testGettingAllBlogPostsRelatedToTagByID()
    {
        $this->assertIsArray(BlogPostTag::fetchBlogPostsRelatedToTagByID(1));
    }

    public function testGettingAllBlogPostsRelatedToTagByName()
    {
        $this->assertIsArray(BlogPostTag::fetchBlogPostsRelatedToTagByName("Introduction"));
    }

    public function testGettingAllBlogPostsRelatedToTagByIDFailure()
    {
        $this->assertFalse(BlogPostTag::fetchBlogPostsRelatedToTagByID(0));
    }

    public function testGettingAllBlogPostsRelatedToTagByNameFailure()
    {
        $this->assertFalse(BlogPostTag::fetchBlogPostsRelatedToTagByName("Yo Momma Is Ugly"));
    }

    public function testTagObjectLoad()
    {
        $myTag = new BlogPostTag;
        $myTag->loadTagByID(1);
        $this->assertInstanceOf(\BlogPostTag::class, $myTag);
    }

    public function testTagGetIDFailure()
    {
        $myTag = new BlogPostTag;
        $this->assertFalse($myTag->getID());
    }

    public function testTagGetNameFailure()
    {
        $myTag = new BlogPostTag;
        $this->assertFalse($myTag->getName());
    }
    
    public function testTagIDLoad()
    {
        $myTag = new BlogPostTag;
        $myTag->loadTagByID(1);
        $this->assertTrue($myTag->getID()==1);
    }

    public function testTagNameLoad()
    {
        $myTag = new BlogPostTag;
        $myTag->loadTagByID(1);
        $this->assertTrue($myTag->getName()=="Introduction");
    }


     /*===========================
    IMAGE TESTING
    ===========================*/    
    public function testImageIDLoad()
    {
        $myImage = new Image;
        $myImage->loadImageByID(1);
        $this->assertTrue($myImage->getName() == "Maeby Picture");
    }

    public function testImageNameLoad()
    {
        $myImage = new Image;
        $myImage->loadImageByName("Maeby Picture");
        $this->assertTrue($myImage->getName() == "Maeby Picture");
    }

    public function testImageFileNameLoad()
    {
        $myImage = new Image;
        $myImage->loadImageByFileName("TopOfStepsMaeby.png");
        $this->assertTrue($myImage->getName() == "Maeby Picture");
    }

    public function testloadImageByBlogPostIDAndImageType()
    {
        $myImage = new Image;
        $myImage->loadImageByBlogPostIDAndImageType(1,"Header");
        $this->assertTrue($myImage->getName() == "Maeby Picture");
    }

    public function testGetImageTypeIDByName()
    {
        $this->assertTrue(Image::getImageTypeIDByName('Header') == 1);
    }

    public function testGetImageTypeNameByID()
    {
        $this->assertTrue(Image::getImageTypeNameByID(1) == 'Header');
    }


    /*===========================
    BLOG POST TESTING
    ===========================*/
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
    }| mvdcsaZ+
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
        $testDatabase->connect();
    }
*/
?>
