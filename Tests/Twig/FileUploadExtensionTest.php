<?php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use tps\DndFileUploadBundle\Tests\AppKernel;
use tps\DndFileUploadBundle\Twig\FileUploadExtension;

/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 28.07.13
 * Time: 20:33
 */

/**
 * Class FileUploadExtensionTest
 *
 * dnd_file_upload:
 *     target_directory: web/uploads
 *
 *
 */

class FileUploadExtensionTest extends WebTestCase {

    public static function createKernel(array $options = array()) {
        return new AppKernel('config.default.yml');
    }

    public function testExtensionsUsesContainerId() {
        $client = $this->createClient();
        $containerInterface = $client->getContainer();
        $fileUploadExtension = new FileUploadExtension($containerInterface, $containerInterface->get('twig'));
        $this->assertContains('sweetTesting', $fileUploadExtension->DndFileUploadContainerFilter('sweetTesting'));
    }

    public function testDefaultCssClassIsUsed() {
        $client = $this->createClient();
        $containerInterface = $client->getContainer();
        $defaultCssClass = $containerInterface->getParameter('dnd_file_upload.twig.css_class');
        $fileUploadExtension = new FileUploadExtension($containerInterface, $containerInterface->get('twig'));
        $this->assertContains($defaultCssClass, $fileUploadExtension->DndFileUploadContainerFilter('sweetTesting'));
    }

    public function testGetDivContainerCssClass() {
        $client = $this->createClient();
        $containerInterface = $client->getContainer();
        $fileUploadExtension = new FileUploadExtension($containerInterface, $containerInterface->get('twig'));
        $this->assertNotEmpty($fileUploadExtension->getDivContainerCssClass());
        $fileUploadExtension->setDivContainerCssClass('sweetTesting');
        $this->assertEquals('sweetTesting', $fileUploadExtension->getDivContainerCssClass());
    }
}