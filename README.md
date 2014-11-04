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

Create and upload-container:
```twig
{% block body %}
    {{ DndFileUploadContainer('file-upload-container') }}
{% endblock %}
```
### Load assets
#### using assetic:
```twig
{% javascripts
    '@DndFileUploadBundle/Resources/public/js/class.FileUploader.js'
    '@DndFileUploadBundle/Resources/public/js/class.UploadThreadWrapper.js'
    '@DndFileUploadBundle/Resources/public/js/bind.js'
%}
    <script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}
```

#### using "normal" assets
```twig
{% block javascripts %}
    {{ parent() }}
    <script type="text/javascript" src="{{ asset('bundles/dndfileupload/js/class.FileUploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/dndfileupload/js/class.UploadThreadWrapper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/dndfileupload/js/bind.js') }}"></script>
{% endblock

{% block stylesheets %}
    {{ parent() }}
    <link href="{{ asset('bundles/dndfileupload/css/default.css') }}" type="text/css" rel="stylesheet" media="screen" />
{% endblock %}

```

### doctrine schema update

This is only necessary if you want the uploaded files to be persisted in the database
Check the File entity in this bundle.

```bash
app/console doctrine:schema:update --force
````

### To Do

I want to inject the entity class to the controller so you can easily overwrite it with your own