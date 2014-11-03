<?php

namespace tps\DndFileUploadBundle\Tests\Service;

use tps\DndFileUploadBundle\Entity\File;
use tps\DndFileUploadBundle\Service\DndFileUploadService;

class DndFileUploadServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DndFileUploadService
     */
    private $service;

    public function setUp()
    {
        $this->service = new DndFileUploadService();
    }

    public function testSetSupportedMimetypes()
    {
        $this->service->setSupportedMimetypes(array('*'));
        $this->assertEquals(array('*'), $this->service->getSupportedMimetypes());
    }

    /**
     * @dataProvider getCheckMimetypeData
     */
    public function testCheckMimetypeAllAllowed(array $supportedTypes, $actualType, $expectedResult)
    {
        $this->service->setSupportedMimetypes($supportedTypes);
        $file = new File();
        $file->setMimetype($actualType);
        $this->assertEquals($expectedResult, $this->service->checkMimeType($file));
    }

    /**
     * @return array
     */
    public function getCheckMimetypeData()
    {
        return array(
            array(
                array('*'),
                'image/jpeg',
                true
            ),
            array(
                array('images/jpeg'),
                'images/jpeg',
                true
            ),
            array(
                array('images/png'),
                'images/jpeg',
                false
            ),
            array(
                array('images/png', 'images/jpeg'),
                'images/jpeg',
                true
            ),
            array(
                array('images/png', 'text/plain'),
                'images/jpeg',
                false
            ),
            array(
                array('images/png', 'text/plain', '*'),
                'text/plain',
                true
            ),
        );
    }
}