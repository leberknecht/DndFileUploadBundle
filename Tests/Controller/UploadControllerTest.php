<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 11.08.13
 * Time: 21:15
 */

namespace tps\DndFileUploadBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\BrowserKit\Client;
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

    public function setUp() {
        $this->client = $this->createClient();
        $this->router = $this->client->getContainer()->get('router');
        $this->client->getContainer()->set('twig', new \Twig_Environment());
        $this->extension = $this->client->getContainer()->get('dnd_file_upload.file_upload_extension');
    }

    public function testUploadErrorOnInvalidMimetype() {
        $source = tempnam(sys_get_temp_dir(), 'source');
        file_put_contents($source, 'hello testing');
        $target = sys_get_temp_dir().'/sf.moved.file';
        @unlink($target);
        $files = new UploadedFile($source, 'original', 'mime/original', 123, UPLOAD_ERR_OK);

        $extensionConfig = $this->client->getContainer()->get('dnd_file_upload.config');
        $extensionConfig->setSupportedMimetypes('none');
        $this->client->request('POST', $this->router->generate('dnd_file_upload_filepost'), array(), array($files));
        $this->assertEquals(
            json_encode(array(
                    'error' => 1,
                    'error_message' => 'unsupported filetype: text/plain'
                )),
            $this->client->getResponse()->getContent()
        );

        @unlink($target);
    }
}