$(document).ready(function() {

    $.fn.imageEventHandler = function (type, action, image, edit) {
        var action = action || false,
             image = image || false,
              type = type || false,
              edit = edit || false;
        if (type === false || action === false)
            return null;
        // The 'display' action calls for creation of image
        // elements to display the newly uploaded images...
        if (action === "display") {
            $.fn.createImageElement(type, image);
        }
    }

    $.fn.createImageElement = function(type, image) {
        var image = image || false,
             type = type || false;
        if (image === false || type === false)
            return null;
        if (type === 'cover') {
            $.fn.createImageElementForCover(image);
        } else if (type === 'ckeditor') {
            $.fn.createImageElementForCKEditor(image);
        } else {
            $.fn.createImageElementForNormalImages(image);
        }
    }

    $.fn.createImageElementForCover = function(image) {
        var image = image || false;
        var divContainer = $("#image-cover");
        divContainer.children().remove();
        // Elements to clone
        var div     = $("<div>");
        var span    = $("<span>");
        var input   = $("<input>");
        //
        console.log(image.path);
        var showcase = div.clone().attr("class", "showcase-cover").appendTo(divContainer);
        var imgElmnt = $("<img>").attr("src", image.path).appendTo(showcase);
        console.log(imgElmnt);
        var inpCaption = input.clone().attr({
            "type": "text",
            "name": "caption-cover",
            "placeholder": "Caption"
        }).appendTo(showcase);
        var spanButton = span.clone().attr({
            "class": "image-event-button",
            "data-type": "cover",
            "data-action": "remove",
            "data-id": image.id
        }).appendTo(showcase);
        var inpHidden = input.clone().attr({
            "type": "hidden",
            "name": "image-cover",
            "value": image.id
        }).appendTo(showcase);
        var spanIcon   = span.clone().attr({"class": "font-icon icon-cancel"}).appendTo(spanButton);
        var spanText   = span.clone().html("Remove image").appendTo(spanButton);
        // Bind the button to do that stuff
        // you know you want it to do...
        spanButton.click(function () {
            $.fn.imageEventClick($(this));
        });
    }


    $.fn.onReadyCover = function (response) {
        // Reset the file input and
        // remove the progressbar
        this.defaultOnReady();
        var image = jQuery.parseJSON(response);
        if (image.error) {
            $.fn.createErrorMessage(image.error.message);
        } else {
            $.fn.imageEventHandler("cover", "display", image);
        }
    };

    $.fn.onReady = function (response) {
        // Reset the file input and
        // remove the progressbar
        this.resetFileInput();
        // Reset the global imageArray
        imageArray = [];
    }

    /**
     * Overrides the Dropify default function
     * onUpload, making sure the upload progress
     * is tailored for the Helium app.
     *
     * @param   progressEvent
     */
    /*$.fn.onUpload = function (event) {
        // Keyword "this" gives access to the
        // plugins settings variables, where
        // the progressbar element can be stored
        // inside the variable monitor.
        var self = this;
        // Create the progress bar object, and
        // connect it to the Dropify plugin, if
        // it already does not exist.
        if ($("#progress-bar-container").length < 1) {
            var element = $("<div>").attr({
                "id": "progress-bar-container"
            }).appendTo("body");
            self.monitor = new ProgressBar ({ parentElement: element });
            self.monitor.createBar();
        }
        // Calculate the upload process
        var completed = 0;
        if (event.lengthComputable) {
            // The uploading process is only
            // part one of the whole process,
            // that also includes resizing of
            // images. Therefore, divide this
            // status by two.
            completed = Math.round((event.loaded / event.total * 1000) / 10 / 2);
            self.monitor.setProgress(completed);
        }
    }*/

    /**
     * Overrides the Dropify default function
     * onDownload, for when the server sends
     * the uploaded images paths back.
     *
     * @param   progressEvent
     */
    $.fn.onDownload = function (event) {
        // Check if the global array ImageArray is set
        if (typeof imageArray === typeof undefined)
            imageArray = [];
        // Options for the on progress monitoring the "stream".
        this.previousBuffer  = "";
        this.totalSizeLoaded += 1;
        // Onprogress will monitor the stream coming
        // back from the server. The stream will be
        // buffered and contains the old response as well.
        // Cut out the latest part and show the newest image.
        var response = event.currentTarget.response;
        var contents = response.substring(this.previousBuffer.length);
        /*var monitor  = this.monitor;
        var progress = monitor.getProgress();
        // Set the progress bar status.
        var completed = (Math.round((this.totalSizeLoaded / this.totalSizeToLoad * 1000) / 10 / 2) + progress);
        this.monitor.setProgress(completed);
        this.previousBuffer = response;*/
        // Nasty fix for streaming bug that occurs
        // when the server sends the JSON encoded
        // strings all at once, which means that
        // the JSON array is actually just a string.
        // Stream array will place a newline between
        // the } {-brackets and then split the string
        // by the newline, making it an array again.
        var streamArray = contents.replace(/(\}([\s\S]*?)\{)/gi, "}\n{");
        streamArray = streamArray.split("\n");
        // Create an array to hold images already added
        try {
            // If it is an array, then loop through
            // it and analyze the values.
            if (streamArray.length > 0) {
                $.each(streamArray, function (i, content) {
                    // Make sure it's not empty
                    if (content.length > 0) {
                        var image = jQuery.parseJSON(content);
                        if (image.error) {
                            $.fn.createErrorMessage(image.error.message);
                            // monitor.remove();
                        } else {
                            if ($.inArray(image.id, imageArray) === -1) {
                                imageArray.push(image.id);
                                $.fn.createImageElement(image);
                            }
                        }
                    }
                });
            }
        } catch (e) {
            console.log("Error " + e);
        }
    }

    /**
     * Overrides the Dropify default function
     * onDownload, for when the server sends
     * the uploaded images paths back. Just
     * for CKEditor images.
     *
     * @param   progressEvent
     */
    $.fn.onDownloadCKEditor = function (event) {
        // Check if the global array ImageArray is set
        if (typeof imageArray === typeof undefined)
            imageArray = [];
        // Options for the on progress monitoring the "stream".
        this.previousBuffer  = "";
        this.totalSizeLoaded += 1;
        // Onprogress will monitor the stream coming
        // back from the server. The stream will be
        // buffered and contains the old response as well.
        // Cut out the latest part and show the newest image.
        var response = event.currentTarget.response;
        var contents = response.substring(this.previousBuffer.length);
        var monitor  = this.monitor;
        var progress = monitor.getProgress();
        // Set the progress bar status.
        var completed = (Math.round((this.totalSizeLoaded / this.totalSizeToLoad * 1000) / 10 / 2) + progress);
        this.monitor.setProgress(completed);
        this.previousBuffer = response;
        // Nasty fix for streaming bug that occurs
        // when the server sends the JSON encoded
        // strings all at once, which means that
        // the JSON array is actually just a string.
        // Stream array will place a newline between
        // the } {-brackets and then split the string
        // by the newline, making it an array again.
        var streamArray = contents.replace(/(\}([\s\S]*?)\{)/gi, "}\n{");
        streamArray = streamArray.split("\n");
        // Create an array to hold images already added
        try {
            // If it is an array, then loop through
            // it and analyze the values.
            if (streamArray.length > 0) {
                $.each(streamArray, function (i, content) {
                    // Make sure it's not empty
                    if (content.length > 0) {
                        var image = jQuery.parseJSON(content);
                        if (image.error) {
                            $.fn.createErrorMessage(image.error.message);
                            monitor.remove();
                        } else {
                            if ($.inArray(image.id, imageArray) === -1) {
                                imageArray.push(image.id);
                                $.fn.createCKEditorImageElement(image);
                            }
                        }
                    }
                });
            }
        } catch (e) {
            console.log("Error " + e);
        }
    }

});
