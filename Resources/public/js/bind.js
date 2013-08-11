$().ready(function(){
    $(dndFileUploadSelector).each(function(){
        new FileUploader(this);
    });
});