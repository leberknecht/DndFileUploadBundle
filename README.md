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
<pre><code>//app/Resources/config/config.yml
dnd_file_upload:
    twig:
        # the css class that is used for the main-container div element
        css_class:            dnd-file-upload-container

    # the directory that files are moved to after upload succeeds
    upload_directory:     web/uploads # Example: /var/userUploads

    # a list of allowed mimetypes, comma-separated, use "*" to allow all
    allowed_mimetypes:    *</code></pre>

### Controller
<pre><code>public function viewAction()
    {
        return $this->render(
            'bundle:controller:view.html.twig',
            array(
                'divContainerCssClass' => $this->get('service_container')->getParameter('dnd_file_upload.twig.css_class')
            )
        );
    }</code></pre>

### View-Config
<pre><code>{% block body %}
{{ DndFileUploadContainer('fileUploadContainer') }}

    {% block javascripts %}
        <script>
            var dndFileUploadSelector = '.{{ divContainerCssClass }}';
        </script>
        {% javascripts
        '@DndFileUploadBundle/Resources/public/js/jquery-2.0.3.min.js'
        '@DndFileUploadBundle/Resources/public/js/class.FileUploader.js'
        '@DndFileUploadBundle/Resources/public/js/class.UploadThreadWrapper.js'
        '@DndFileUploadBundle/Resources/public/js/bind.js'
        %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
        {% endjavascripts %}
    {% endblock %}</code></pre>

### doctrine schema update
Run app/console doctrine:schema:update --force (a table named "dnd_file_uploads" will be created)

Next steps
----------
- make the entity persist optional
- make the entity class injectable
- i could need some help with the parameter handling, i think that the setParameter calls
in the DndFileUploadExtension should not be necessary
- adding "profiles" array to the configuration so you can have multiple upload configurations
- i thing my testing environment could be cleaned up a little bit, it consists of snippets from
other bundles as i found it pretty confusing making the webtestcases running without an app..well
i'm new to this, so that might be normal ^^

https://travis-ci.org/leberknecht/DndFileUploadBundle.png