function UploadThreadWrapper(file, targetUrl) {
    var $myProgressBarContainer;
    var xhr = new XMLHttpRequest();

    function upload($progressBarContainer, fileGroupHash) {
        $myProgressBarContainer = $progressBarContainer;
        sendFile(fileGroupHash);
    }

    function sendFile(fileGroupHash) {
        var myFormData = new FormData();
        myFormData.append('file', file);
        if (fileGroupHash) {
            myFormData.append('fileGroup', fileGroupHash);
        }
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.onreadystatechange = handleResponse;
        xhr.open("POST", targetUrl);
        xhr.send(myFormData);
    }

    function handleResponse() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = jQuery.parseJSON(xhr.responseText);
            if (obj.error != 0) {
                $('.status_and_options',$myProgressBarContainer).append('<p>' + obj.error_message + '</p>');
                $('.status_bar_progress',$myProgressBarContainer).css('width', 0);
            } else {
                finishUpload();
                $('.status_and_options',$myProgressBarContainer).append('<a href="'+obj.link+'">link</a>');
            }
        }
    }

    function finishUpload() {
        var fullWidth = $('.status_bar_container',$myProgressBarContainer).width();
        $('.status_bar_progress',$myProgressBarContainer).css('width', fullWidth);
        $('.status_and_options',$myProgressBarContainer).html('<p>Finished!</p>');
    }

    function uploadProgress(evt) {
        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
        var fullWidth = $('.status_bar_container',$myProgressBarContainer).width();
        $('.status_bar_progress',$myProgressBarContainer).css('width', (fullWidth / 100) * percentComplete);
        $('.status_and_options',$myProgressBarContainer).html('<p>'+percentComplete+'%</p>');
    }

    return {
        upload:upload
    }
}
