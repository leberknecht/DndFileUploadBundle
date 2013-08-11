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

class flushMock {
    function flush() {

    }
}

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

    private function getFile() {
        return array('tmp_name' => 'README.md', 'name' => 'org_name', 'type' => 'wantToFail', 'size' => 2);
    }

    public function testUploadErrorOnInvalidMimetype() {
        file_put_contents('testtmp.txt', 'sweet testing', FILE_APPEND);
        $_FILES['file'] = $this->getFile();
        $_FILES['file']['tmp_name'] = 'testtmp.txt';
        $this->extension->setSupportedMimetypes('none');
        $this->client->request('POST', $this->router->generate('dnd_file_upload_filepost'), array(), array());
        $this->assertEquals(
            json_encode(array(
                    'error' => 1,
                    'error_message' => 'unsupported filetype: text/plain'
            )),
            $this->client->getResponse()->getContent()
        );
        unlink('testtmp.txt');
    }
}