<?php
namespace tps\DndFileUploadBundle\Tests\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Templating\TemplateNameParser;
use tps\DndFileUploadBundle\Tests\BaseTestCase;
use tps\DndFileUploadBundle\Twig\FileUploadExtension;

/**
 * Class FileUploadExtensionTest
 *
 * dnd_file_upload:
 *     target_directory: web/uploads
 */
class FileUploadExtensionTest extends BaseTestCase
{

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
        $this->fileUploadExtension = $this->containerInterface->get('dnd_file_upload.file_upload_extension');
    }

    public function testDefaultCssClassIsUsed()
    {
        $defaultCssClass = $this->containerInterface->getParameter('dnd_file_upload.twig.css_class');
        $twig = $this->containerInterface->get('twig');

        $this->assertContains(
            $defaultCssClass,
            $this->fileUploadExtension->getDndFileUploadContainer($twig, 'sweetTesting')
        );
    }

    public function testGetDivContainerCssClass()
    {
        $this->assertNotEmpty($this->fileUploadExtension->getDivContainerCssClass());
        $this->fileUploadExtension->setDivContainerCssClass('sweetTesting');
        $this->assertEquals(
            'sweetTesting',
            $this->fileUploadExtension->getDivContainerCssClass(
                $this->containerInterface->get('twig')
            )
        );
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
                    "is_safe" => array("html"),
                    'needs_environment' => true,
                )
            ),
            new \Twig_SimpleFunction('DndFileUploadAssets',
                array(
                    $this->fileUploadExtension,
                    'DndFileUploadAssetsFilter',
                ),
                array(
                    "is_safe" => array("html"),
                    'needs_environment' => true,
                )
            ),
        );
        $this->assertEquals($expected, $this->fileUploadExtension->getFunctions());
    }
}
