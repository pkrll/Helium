$(document).ready(function() {

    /**
     * Remove or display uploaded images.
     *
     * @param   string  Type of image (cover | normal | ckeditor).
     * @param   string  Action requested (display | remove).
     * @param   int     Id of uploaded image.
     * @param   bool    OPTIONAL. If the image has already been
     *                  attached to the article, this value must
     *                  be true when calling the event handler-
     *                  function.
     * @returns void
     */
    $.fn.imageEventHandler = function (type, action, image, edit) {
        var type = type || false, action = action || false, image = image || false, edit = edit || false;
        if (type === false || action === false)
            return null;
        // The 'display' action calls for creation of image
        // elements to display the newly uploaded images...
        if (action === "display") {
            $.fn.createImageElement(type, image);
        } else if (action === "remove") {
            if (image === false)
                return false;
            $.fn.removeImageElement(type, image, edit);
        }
    }

    /**
     * Remove an image element. If the image has already been
     * attached to the post (when the article is being edited)
     * this function will also create a hidden input element
     * with the image's id to notify the server of the event.
     *
     * @param   string  Type of image (cover | normal | ckeditor).
     * @param   int     Id of uploaded image.
     * @param   bool    OPTIONAL. If the image has already been
     *                  attached to the article, this value must
     *                  be true when calling the event handler-
     *                  function.
     * @returns void
     */
    $.fn.removeImageElement = function(type, imageID, edit) {
        // If the image is already attached to the article, the server needs to know which one to remove
        if (edit !== false) {
            var parentElement = $("#form");
            var hiddenElement = $("<input>").attr({
                "type": "hidden",
                "value": imageID,
                "name": "image-remove[]"
            }).appendTo(parentElement);
        }
        // Remove the image element
        $("div[data-id='"+imageID+"']").remove();
        if (type === "cover")
            $("#image-cover").children().show();
    }

    /**
     * Calls the right image element creation function
     * depending on the type of image uploaded.
     *
     * @param   string  Type of image (cover | normal | ckeditor).
     * @param   int     Id of uploaded image.
     * @returns void
     */
    $.fn.createImageElement = function(type, image) {
        if (type === false || image === false)
            return null;
        if (type === 'cover') {
            $.fn.createImageElementForCover(image);
        } else if (type === 'ckeditor') {
            $.fn.createImageElementForCKEditor(image);
        } else {
            $.fn.createImageElementForNormalImages(image);
        }
    }

    /**
     * Create an image element for cover images.
     *
     * @param   int     Id of uploaded image.
     * @returns void
     */
    $.fn.createImageElementForCover = function(image) {
        if (image === false)
            return false;
        var divContainer = $("#image-cover");
        divContainer.children().hide();
        // Elements to clone
        var div     = $("<div>");
        var span    = $("<span>");
        var input   = $("<input>");
        // The cover image element
        var showcase = div.clone().attr({
            "class": "showcase-cover",
            "data-id": image.id
        }).appendTo(divContainer);
        var imgElmnt = $("<img>").attr({
            "src": image.path
        }).appendTo(showcase);
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
        var spanText   = span.clone().html(" Remove image").appendTo(spanButton);
        // Bind the button to do that stuff
        // you know you want it to do...
        spanButton.click(function () {
            $.fn.imageEventHandler("cover", "remove", $(this).attr("data-id"));
        });
    }

    /**
     * Create an image element for "normal" images.
     *
     * @param   int     Id of uploaded image.
     * @returns void
     */
    $.fn.createImageElementForNormalImages = function(image) {
        var parent  = $(".showcase-image");
        // Clone pool
        var div     = $("<div>");
        var img     = $("<img>");
        var span    = $("<span>");
        var input   = $("<input>");
        // Create the image element
        var pictureDiv = div.clone().attr({
            "class"     : "picture",
            "data-id"   : image.id
        }).appendTo(parent);
        var pictureBox = div.clone().attr({
            "class": "picture-box"
        }).appendTo(pictureDiv);
        var imgElement = img.clone().attr({
            "src": image.path
        }).appendTo(pictureBox);
        // The caption
        var divCaption = div.clone().attr({
            "class": "caption"
        }).appendTo(pictureDiv);
        var divElement = div.clone().appendTo(divCaption);
        var spanButton = span.clone().attr({
            "class"         : "image-event-button",
            "data-type"     : "image",
            "data-action"   : "remove",
            "data-id"       : image.id
        }).appendTo(divElement);
        var spanTrash  = span.clone().attr({
            "class": "font-icon icon-cancel"
        }).appendTo(spanButton);
        var spanText   = span.clone().html(" Remove image").appendTo(spanButton);
        var divElement = div.clone().appendTo(divCaption);
        var inpCaption = input.clone().attr({
            "type": "text",
            "name": "caption-image[]",
            "placeholder": "Caption"
        }).appendTo(divElement);
        var inpHidden  = input.clone().attr({
            "type": "hidden",
            "name": "image[]",
            "value": image.id
        }).appendTo(divElement);
        // Bind the button to do that stuff
        // you know you want it to do...
        spanButton.click(function () {
            $.fn.imageEventHandler("normal", "remove", $(this).attr("data-id"));
        });
    }

    /********************************************
     *              DROPIFY FUNCTIONS           *
     ********************************************/

    /**
     * Overrides Dropify's OnReady()-method for the
     * cover image uploads.
     *
     * @param   JSON    Response from server
     * @returns void
     */
    $.fn.onReadyCover = function (response) {
        // Reset the file input and
        // remove the progressbar
        this.resetFileInput();
        this.monitor.remove();
        var image = jQuery.parseJSON(response);
        if (image.error) {
            $.fn.createErrorMessage(image.error.message);
        } else {
            $.fn.imageEventHandler("cover", "display", image);
        }
    };

    /**
     * Overrides Dropify's OnReady()-method for the
     * normal image uploads.
     *
     * @param   JSON    Response from server
     * @returns void
     */
    $.fn.onReady = function (response) {
        // Reset the file input and
        // remove the progressbar
        this.resetFileInput();
        // Remove the progressbar
        this.monitor.remove();
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
    $.fn.onUpload = function (event) {
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
    }

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
                        } else {
                            if ($.inArray(image.id, imageArray) === -1) {
                                imageArray.push(image.id);
                                $.fn.imageEventHandler("normal", "display", image);
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
