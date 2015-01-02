[![Build Status](https://travis-ci.org/leberknecht/DndFileUploadBundle.png)](https://travis-ci.org/leberknecht/DndFileUploadBundle)
[![Coverage Status](https://coveralls.io/repos/leberknecht/DndFileUploadBundle/badge.png)](https://coveralls.io/r/leberknecht/DndFileUploadBundle)

Drag-And-Drop File-Upload Bundle
================================

A drag-and-drop file-upload bundle for symfony2

Installation
------------
Add the following line to your composer.json:

```yaml
require: "tps/dnd-file-upload-bundle": "dev-master"
```
Update your dependencies and activate the bundle in the kernel:
```php
//app/AppKernel.php
$bundles = array(
    [...]
    new \tps\DndFileUploadBundle\DndFileUploadBundle()
)
```

Usage
-----

### App-Config
```yaml
#app/Resources/config/config.yml
dnd_file_upload:
    twig:
        css_class:        dnd-file-upload-container
    upload_directory:     uploads
    allowed_mimetypes:    [ '*' ]
    persist_entity:       true
    entity_class:         Acme\DemoBundle\Entity\MyUploadedFile
```

### Entity

```php
namespace Acme\DemoBundle\Entity;

use tps\DndFileUploadBundle\Entity\File as UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="file_uploads") //remove this if you dont want to persist
 * @ORM\Entity()
 */
class MyUploadedFile extends UploadedFile
{
     /**
      * @var integer $id
      *
      * @ORM\Column(name="id", type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      */
     protected $id;
}
```

If you want the uploaded files to be persisted in your database, run:
```bash
app/console doctrine:schema:update --force
````

### Enable routing
```yaml
# app/Resources/config/routing.yml
dnd_file_upload_routing:
    resource: "@DndFileUploadBundle/Resources/config/routing.yml"
```

### View

If you dont have jQuery included allready, do so before you include bundle snippets:
```twig
<script src="http://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
``` 

#### Loading assets

Using assetic:
```twig
{% javascripts
    '@DndFileUploadBundle/Resources/public/js/class.FileUploader.js'
    '@DndFileUploadBundle/Resources/public/js/class.UploadThreadWrapper.js'
    '@DndFileUploadBundle/Resources/public/js/bind.js'
%}
    <script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}
```

Using "normal" assets:
```twig

{% block javascripts %}
    {{ parent() }}    
    <script type="text/javascript" src="{{ asset('bundles/dndfileupload/js/class.FileUploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/dndfileupload/js/class.UploadThreadWrapper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/dndfileupload/js/bind.js') }}"></script>
{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link href="{{ asset('bundles/dndfileupload/css/default.css') }}" type="text/css" rel="stylesheet" media="screen" />
{% endblock %}
```
#### create upload-container

Finally, create the upload-container (the "file-upload-container" parameter is the id of the container in the DOM, 
use it for styling):
```twig
{# Acme\DemoBundle\Resources\views\index.html.twig #}
{% block body %}
    {{ DndFileUploadContainer('file-upload-container') }}
{% endblock %}
```

### To Do
- add JS tests
