<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use tps\DndFileUploadBundle\Tests\BaseTestCase;
use tps\DndFileUploadBundle\Twig\FileUploadExtension;

/**
 * Class FileUploadExtensionTest
 *
 * dnd_file_upload:
 *     target_directory: web/uploads
 */

class FileUploadExtensionTest extends BaseTestCase {

    /**
     * @var FileUploadExtension
     */
    private $fileUploadExtension;

    /**
     * @var ContainerInterface
     */
    private $containerInterface;

    public function setUp()
    {
        $client = $this->createClient();
        $this->containerInterface = $client->getContainer();
        $this->fileUploadExtension = new FileUploadExtension($this->containerInterface->get('templating'));
        $sup = $this->fileUploadExtension->getSupportedMimetypes();
        echo "debug got mimes: " . var_export($sup, true). PHP_EOL;
    }
/*
    public function testDefaultCssClassIsUsed() {
        $defaultCssClass = $this->containerInterface->getParameter('dnd_file_upload.twig.css_class');
        $this->assertContains($defaultCssClass, $this->fileUploadExtension->getDndFileUploadContainer('sweetTesting'));
    }
*/
    public function testGetDivContainerCssClass() {
        $this->assertNotEmpty($this->fileUploadExtension->getDivContainerCssClass());
        $this->fileUploadExtension->setDivContainerCssClass('sweetTesting');
        $this->assertEquals('sweetTesting', $this->fileUploadExtension->getDivContainerCssClass());
    }

    public function testGetFunctions()
    {
        $expected = array(
            new \Twig_SimpleFunction('DndFileUploadContainer',
                array(
                    $this->fileUploadExtension,
                    'getDndFileUploadContainer',
                ),
                array(
                    "is_safe" => array("html")
                )
            ),
            new \Twig_SimpleFunction('DndFileUploadAssets',
                array(
                    $this->fileUploadExtension,
                    'DndFileUploadAssetsFilter',
                ),
                array(
                    "is_safe" => array("html")
                )
            ),
        );
        $this->assertEquals($expected, $this->fileUploadExtension->getFunctions());
    }
}
