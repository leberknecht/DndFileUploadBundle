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

Usage
-----
### App-Config
```yaml
#app/Resources/config/config.yml
dnd_file_upload:
    twig:
        css_class:        dnd-file-upload-container
    upload_directory:     web/uploads
    allowed_mimetypes:    [ '*' ]
    persist_entity:       false
```

### Routing
```yaml
# app/Resources/config/routing.yml
dnd_file_upload_routing:
    resource: "@DndFileUploadBundle/Resources/config/routing.yml"
```

### View

```twig
{% block body %}
    {{ DndFileUploadContainer('fileUploadContainer') }}

    {{ DndFileUploadAssets() }}
{% endblock %}
```

### doctrine schema update
Run 
```bash
app/console doctrine:schema:update --force
````



