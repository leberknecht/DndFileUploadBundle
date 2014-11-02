<?php
namespace tps\DndFileUploadBundle\Tests\Entity;

use tps\DndFileUploadBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function testGetFullPathName()
    {
        $this->file->setDirectory('testDir');
        $this->file->setFilename('testfile.test');
        $this->assertEquals('testDir/testfile.test', $this->file->getFullPathName());
    }

    public function testUploadNoFileSet()
    {
        $this->assertNull($this->file->upload('./test'));
    }

    public function testUploadFileFileSet()
    {
        $uploadedFile = $this->getMockBuilder('Symfony\Component\HttpFoundation\File\UploadedFile')
                            ->disableOriginalConstructor()->getMock();
        $this->file->setFilename('testing');
        $uploadedFile->expects($this->once())
            ->method('move')
            ->with('./test','testing');
        $this->file->setFile($uploadedFile);
        $this->file->upload('./test');
    }

    public function testGetMimetype()
    {
        $this->file->setMimetype('image/test');
        $this->assertEquals('image/test', $this->file->getMimetype());
    }

    public function testGetFile()
    {
        $uploadedFile = $this->getMockBuilder('Symfony\Component\HttpFoundation\File\UploadedFile')
                            ->disableOriginalConstructor()->getMock();
        $this->file->setFile($uploadedFile);
        $this->assertEquals($uploadedFile, $this->file->getFile());
    }
}
