$().ready(function(){
    var fileUploadSelector = $('.upload-slot-template').data('file-upload-selector')
    $(fileUploadSelector).each(function(){
        new FileUploader(this);
    });
});