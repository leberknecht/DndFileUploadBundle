<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 10.08.13
 * Time: 22:26
 */

namespace tps\DndFileUploadBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use tps\DndFileUploadBundle\DependencyInjection\Configuration;
use tps\DndFileUploadBundle\DependencyInjection\DndFileUploadExtension;

class DndFileUploadExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testContainerLoadsFineWithDefaultConfig() {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $dndFileUploadExtension->load(array(array()), $containerBuilder);
        $this->assertTrue($containerBuilder instanceof ContainerBuilder);
    }

    public function testContainerHasDefinition() {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $dndFileUploadExtension->load(array(array()), $containerBuilder);
        $this->assertTrue($containerBuilder->hasDefinition('dnd_file_upload.file_upload_extension'));
    }

    public function testContainerHasDefinitionOfTwigCssClass() {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $dndFileUploadExtension->load(array(array()), $containerBuilder);
        $this->assertNotEmpty($containerBuilder->getParameter('dnd_file_upload.twig.css_class'));
    }

    public function testContainerHasDefaultDefinitionOfUploadDir() {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $dndFileUploadExtension->load(array(array()), $containerBuilder);
        $this->assertEquals(Configuration::DEFAULT_UPLOAD_DIRECTORY, $containerBuilder->getParameter(
                'dnd_file_upload.upload_directory')
        );
    }

    public function testContainerHasTwigCssClassDefinition()
    {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $dndFileUploadExtension->load(array(array('twig' => array('css_class' => 'testing'))), $containerBuilder);
        $this->assertEquals('testing', $containerBuilder->getParameter('dnd_file_upload.twig.css_class'));
    }

    public function testPersistenceEnabledNoEntitySpecified()
    {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $this->setExpectedException('InvalidArgumentException');
        $dndFileUploadExtension->load(array(array('persist_entity' => true)), $containerBuilder);
    }

    public function testPersistenceEnabledEntitySpecified()
    {
        $containerBuilder = new ContainerBuilder();
        $dndFileUploadExtension = new DndFileUploadExtension();
        $dndFileUploadExtension->load(
            array(
                array(
                    'persist_entity' => true,
                    'entity_class' =>
                        'testClass')
            ),
            $containerBuilder
        );
        $this->assertEquals('testClass', $containerBuilder->getParameter('dnd_file_upload.entity_class'));
    }
} 