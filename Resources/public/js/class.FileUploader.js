function FileUploader(containerDiv) {
    var $myContainer = $(containerDiv),
        FileList,
        TargetPostUrl,
        currentFileIndex,
        currentFileCount = 0,
        SupportedMimeTypes = '',
        $UploadSlotsDiv,
        $centerTextDiv,
        uploadSlotTemplate = '<div class="upload_slot" id="%uploadId%">' +
            '   <div class="upload_label">' +
            '       sending %filename%' +
            '   </div>' +
            '   <div class="status_bar_container">' +
            '       <div class="status_bar_progress">' +
            '       </div>' +
            '   </div>' +
            '   <div class="status_and_options">' +
            '   </div>' +
            '</div>';

    function drop(evt) {
        var files = evt.dataTransfer.files;
        myPreventDefault(evt);

        if (!files) {
            alert("your browser does not support drag-and-drop uploads :/")
            return;
        }

        if (files.length > 0) {
            $centerTextDiv.remove();
            handleFiles(files);
        }
    }

    function showGroupViewLinkIfHidden() {
        if (currentFileCount == 1 && !$FileGroupLinkDiv.is(':visible')) {
            $FileGroupLinkDiv.show('slow');
        }
    }

    function checkMimetype(type) {
        if (SupportedMimeTypes != '*') {
            return $.inArray(type, SupportedMimeTypes.split(',')) != -1;
        }
        return true;
    }

    function handleFiles(files) {
        var $progressDiv,
            fileMimeType;
        FileList = files;

        for (var i = 0; i < FileList.length; i++, currentFileCount++) {
            currentFileIndex = i;
            $progressDiv = createProgressDiv(FileList[currentFileIndex]);
            $UploadSlotsDiv.append($progressDiv);

            if (checkMimetype(FileList[currentFileIndex].type)) {
                uploadFile();
            } else {
                $('.status_and_options',$progressDiv).html(
                    '<div>unsupported Filetype: ' + FileList[currentFileIndex].type + '</div>'
                );
            }
        }
    }

    function uploadFile() {
        var myUploadWrapper = new UploadThreadWrapper(FileList[currentFileIndex], TargetPostUrl);
        myUploadWrapper.upload($('#'+constructDivIdPrefix()), FileGroupHash);
    }

    function createProgressDiv(file) {
        var template = uploadSlotTemplate.split('%uploadId%').join(constructDivIdPrefix())
        template = template.split('%filename%').join(file.name)
        return $(template);
    }

    function constructDivIdPrefix() {
        return $myContainer.attr('id') + '_upload_' + (currentFileCount + currentFileIndex);
    }

    function myPreventDefault(evt) {
        evt.stopPropagation();
        evt.preventDefault();
    }

    function init() {
        TargetPostUrl = $myContainer.data('target-post-url');
        SupportedMimeTypes = $myContainer.data('allowed-extensions');
        var UploadSlotsDivId = $myContainer.data('upload-slots-div');
        var CenterTextDivId = $myContainer.data('center-text-div');
        $UploadSlotsDiv = $('#' + UploadSlotsDivId);
        $centerTextDiv = $('#' + CenterTextDivId);
        bindDragAndDropHandlerToContainer();
    }

    function bindDragAndDropHandlerToContainer() {
        containerDiv.addEventListener("dragenter", myPreventDefault, false);
        containerDiv.addEventListener("dragexit", myPreventDefault, false);
        containerDiv.addEventListener("dragover", myPreventDefault, false);
        containerDiv.addEventListener("drop", drop, false);
    }

    init();
}