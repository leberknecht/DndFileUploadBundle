<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 11.08.13
 * Time: 21:15
 */

namespace tps\DndFileUploadBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use tps\DndFileUploadBundle\Tests\BaseTestCase;
use tps\DndFileUploadBundle\Twig\FileUploadExtension;

class UploadControllerTest extends BaseTestCase {

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var FileUploadExtension
     */
    private $extension;

    /**
     * @var string
     */
    private $target;

    public function setUp() {
        $this->client = $this->createClient();
        $this->router = $this->client->getContainer()->get('router');
        $this->client->getContainer()->set('twig', new \Twig_Environment());
        $this->extension = $this->client->getContainer()->get('dnd_file_upload.file_upload_extension');
        $this->target = sys_get_temp_dir().'/sf.moved.file';
        @unlink($this->target);
    }

    public function tearDown()
    {
        @unlink($this->target);
    }

    public function testUploadErrorOnInvalidMimetype() {
        $source = tempnam(sys_get_temp_dir(), 'source');
        file_put_contents($source, 'hello testing');

        $files = new UploadedFile($source, 'original', 'text/plain', 123, UPLOAD_ERR_OK);

        $extensionConfig = $this->client->getContainer()->get('dnd_file_upload.config');
        $extensionConfig->setSupportedMimetypes(array('none'));

        $this->client->request('POST', $this->router->generate('dnd_file_upload_filepost'), array(), array($files));
        $this->assertEquals(
            json_encode(array(
                    'error' => 1,
                    'error_message' => 'unsupported filetype: text/plain'
                )),
            $this->client->getResponse()->getContent()
        );
    }

    public function testValidFilepost() {
        $source = tempnam(sys_get_temp_dir(), 'source');
        file_put_contents($source, 'hello testing');
        $files = new UploadedFile($source, 'original', 'text/plain', 123, UPLOAD_ERR_OK);

        $extensionConfig = $this->client->getContainer()->get('dnd_file_upload.config');
        $extensionConfig->setSupportedMimetypes(array('*'));

        $this->client->request('POST', $this->router->generate('dnd_file_upload_filepost'), array(), array($files));
        $this->client->getResponse()->getContent();
        $this->assertEquals(
            json_encode(array(
                    'error' => 0
                )),
            $this->client->getResponse()->getContent()
        );
    }


    public function testValidFilepostWithPersist() {
        $this->client = $this->createClient(array('config' => 'config_persist.yml'));

        $emMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $emMock->expects($this->once())
            ->method('persist');
        $emMock->expects($this->once())
            ->method('flush');
        $registryMock = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()->getMock();
        $registryMock->expects($this->once())
            ->method('getManager')
            ->will($this->returnValue($emMock));
        $this->client->getContainer()->set('doctrine', $registryMock);

        $source = tempnam(sys_get_temp_dir(), 'source');
        file_put_contents($source, 'hello testing');
        $files = new UploadedFile($source, 'original', 'text/plain', 123, UPLOAD_ERR_OK);

        $extensionConfig = $this->client->getContainer()->get('dnd_file_upload.config');

        $extensionConfig->setSupportedMimetypes(array('*'));

        $this->client->request('POST', $this->router->generate('dnd_file_upload_filepost'), array(), array($files));
        $this->client->getResponse()->getContent();
        $this->assertEquals(
            json_encode(array(
                    'error' => 0
                )),
            $this->client->getResponse()->getContent()
        );
    }
}