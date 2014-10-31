Drag-And-Drop File-Upload Bundle
================================

A drag-and-drop file-upload bundle for symfony2

Installation
------------
Add the following line to your composer.json:

<pre><code>require: "tps/dnd-file-upload-bundle": "dev-master"</code></pre>

Usage
-----
### App-Config
```yaml
#app/Resources/config/config.yml
dnd_file_upload:
    twig:
        css_class:        dnd-file-upload-container
    upload_directory:     web/uploads
    allowed_mimetypes:    *
    persist_entity:       false
    post_handler_route is defined
    post_handler_route:   upload_post_file
´´´
### Controller

Unfortunately we'll need to pass the css-class name from the controller..if someone knows a more elegant way
to do this it will be very welcome.

```php
use tps\DndFileUploadBundle\Controller\UploadController as dndUploadController;

class UploadController extends dndUploadController {
    public function viewAction()
    {
        return $this->render(
            'bundle:controller:view.html.twig',
            array(
                'divContainerCssClass' => $this->get('service_container')->getParameter('dnd_file_upload.twig.css_class')
            )
        );
    }

    public function postAction()
    {
        $file = new File();
        $em = $this->getDoctrine()->getManager();

        $this->setFilePropertiesByUploadedFile($file);
        $extensionConfig = $this->container->get('dnd_file_upload.config');
        if (false == $this->checkMimeType($file, $extensionConfig->getSupportedMimetypes())) {
            return $this->unsupportedMimetypeResponse($file);
        }

        $file->upload($this->container->getParameter('dnd_file_upload.upload_directory'));
        $em->persist($file);
        $em->flush();

        return new Response(json_encode(array('error' => 0)));
    }

    [...]
}
´´´

### Entity

```php
use tps\DndFileUploadBundle\Entity\File as dndFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Table(name="file_uploads")
 * @ORM\Entity()
 */
class File extends dndFile
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string $directory
     *
     * @ORM\Column(name="directory", type="string", length=255)
     */
    private $directory;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var UploadedFile $file
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="mimetype", type="string", length=20)
     */
    private $mimetype;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=128)
     */
    private $filename;
}
´´´

### View

```twig
{% block body %}
    {{ DndFileUploadContainer('fileUploadContainer') }}

    {{ DndFileUploadAssets() }}
{% endblock %}</code></pre>
´´´

### doctrine schema update
Run app/console doctrine:schema:update --force

Next steps
----------
- i could need some help with the parameter handling, i think that the setParameter calls
in the DndFileUploadExtension should not be necessary
- adding "profiles" array to the configuration so you can have multiple upload configurations
- i thing my testing environment could be cleaned up a little bit, it consists of snippets from
other bundles as i found it pretty confusing making the webtestcases running without an app..well
i'm new to this, so that might be normal ^^

[![Build Status](https://travis-ci.org/leberknecht/DndFileUploadBundle.png)](https://travis-ci.org/leberknecht/DndFileUploadBundle)
