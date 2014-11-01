<?php
namespace tps\DndFileUploadBundle\Tests\Entity;

use tps\DndFileUploadBundle\Entity\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var File $file
     */
    private $file;

    public function setUp() 
    {
        $this->file = new File();
    }

    public function testGetId()
    {
        $this->assertNull($this->file->getId());
    }

    public function testGetCreated()
    {
        $testTime = new \DateTime();
        $this->file->setCreated($testTime);
        $this->assertEquals($testTime, $this->file->getCreated());
    }

    public function testGetName()
    {
        $this->file->setName('testing');
        $this->assertEquals('testing', $this->file->getName());
    }

    public function testGetDirectory()
    {
        $this->file->setDirectory('testing');
        $this->assertEquals('testing', $this->file->getDirectory());
    }

}
