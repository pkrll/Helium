$(document).ready(function() {

    $.fn.onReadyCover = function (response) {
        // Reset the file input and
        // remove the progressbar
        this.resetFileInput();
        this.monitor.remove();
        var image = jQuery.parseJSON(response);
        if (image.error) {
            $.fn.createErrorMessage (Localize.getLocaleString (image.error.message));
        } else {
            $.fn.imageHandlerEvent ("cover", "display", image);
        }
    };

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
                            monitor.remove();
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
     * Binds all buttons with this class
     * to the imageEventClick() function
     * that handles the image related
     * requests.
     *
     */
    $(".image-event-button").click(function(event) {
        event.preventDefault();
        $.fn.imageEventClick($(this));
    });

    /**
     * Calls the image event handler
     * function, before checking that
     * the firing button has all its
     * papers in order.
     *
     * @param Element
     */
    $.fn.imageEventClick = function (element) {
        var action    = element.attr("data-action") || false,
              type    = element.attr("data-type") || false,
              edit    = element.attr("data-edit") || false,
                id    = element.attr("data-id") || false;
        if (type === false || action === false)
			return null;
        // FIRE!
    	$.fn.imageHandlerEvent(type, action, id, edit);
    }

    /**
     * Handles the image events. Calls the
     * upload function, or element creation.
     *
     * @param String The type of image
     * @param String Action requested
     * @param Array Contains the path and id of the image
     */
    $.fn.imageHandlerEvent = function (type, action, image, edit) {
        var action = action || false,
             image = image || false,
              type = type || false,
              edit = edit || false;
        if (type === false || action === false)
            return null;
        // On action Upload
        if (action === "upload") {
            // Get all the elements within
            // the drop target zone of the
            // selected fieldset.
            var parent = $("#dragzone-"+type).find("div.input");
            var elements = parent.children();
            // Must check the selection
            var fileName = $("input#"+type).val();
            if ($.fn.checkExtension(fileName) === false) {
                $.fn.createErrorMessage(Localize.getLocaleString("You can only upload images"));
                return false;
            }
            var file = document.getElementById(type).files[0];
            // Hide the child elements
            // of the dropzone and set
            // the loadimage spinning.
            elements.hide();
            $.fn.createLoaderImage(parent);
            // Create the FormData object
            // and call upload function.
            var data = new FormData();
            data.append("file", file);
            $.fn.uploadImage(type, data, parent);
        } else if (action === "display") {
            // On action display. This means
            // create elements for displaying
            // the uploaded images.
            $.fn.createImageElements(type, image)
        } else if (action === "remove") {
            if (image === false)
                return false;
            $.fn.removeImageElements(type, image, edit);
        }
    }

    /**
     * Remove images
     *
     * @param   string  Type of image
     * @param   string  Id of image
     * @param   bool    Edit mode
     */
    $.fn.removeImageElements = function (type, imageID, edit) {
        var imageID = imageID || false,
               type = type || false,
               edit = edit || false;
        if (type === false)
            return false;
        // If edit option is set, then the server needs
        // to know which images are being removed.
        if (edit === "true") {
            var parentElement   = $("form#article");
            var removedImage    = $("<input>").attr({
                "type": "hidden",
                "value": imageID,
                "name": "image-remove[]"
            }).appendTo(parentElement);
        }
        // Remove the images
        if (type === "cover") {
            $.fn.createCoverImageElement(null, "remove");
        } else {
            $("div[data-id='"+imageID+"']").remove();
        }
    }

    /**
     * Determines which element creation function
     * to call, depending on the type of image.
     *
     * @param String Type of image
     * @param Array Contains the path and id of the image
     * @param String Action requested
     */
    $.fn.createImageElements = function (type, image, action) {
        var action = action || false,
             image = image || false,
              type = type || false;
        if (type === false || image === false)
            return null;
        if (type === "cover") {
            $.fn.createCoverImageElement(image, action);
        } else if (type === "ckeditor") {
            $.fn.createCKEditorImageElement(image);
        } else {
            $.fn.createImageElement(image);
        }
    }

    /**
     * Display the cover image that
     * has been uploaded.
     *
     * @param   array   An array containing information on image
     * @param   string  Type of action requested
     */
    $.fn.createCoverImageElement = function (image, action) {
        var action = action || false,
             image = image || false;
        if (action !== "remove" && image === false)
            return false;

        var parent = $("#dragzone-cover");
        var divContainer = parent.find("div.input");
        divContainer.children().remove();
        // On remove
        if (action === "remove") {
            var div = $("<div>");
            // Remove the children element ...
            divContainer.removeClass('cover');
            // ... and create the new elements
            var divDescription  = div.clone().html(Localize.getLocaleString("Drag and drop a cover image here, or add by using the button below. The image must be below 2 MB.")).appendTo(divContainer);
            var divInput = div.clone().appendTo(divContainer);
            var fileInp  = $("<input>").attr({
                "type": "file",
                "id": "image-cover"
            }).appendTo(divInput);
            var button = $("<button>").attr({
                "class": "image-event-button",
                "data-type": "cover",
                "data-action": "upload"
            }).html(Localize.getLocaleString("Upload")).appendTo(divInput);
            // Bind the button to do that stuff
            // you want it to do, you know...
            button.click(function (e) {
                e.preventDefault();
        		$.fn.imageEventClick($(this));
            });
        } else {
            // Remove the old elements
            divContainer.addClass('cover');
            // Create the div to clone
            var div     = $("<div>");
            var span    = $("<span>");
            var input   = $("<input>");
            // Create the elements that will
            // hold the uploaded image.
            var pictureDiv = div.clone().appendTo(divContainer);
            var imgElement = $("<img>").attr({"src": image.path}).appendTo(pictureDiv);
            var inpCaption = input.clone().attr({
                "type": "text",
                "name": "caption-cover",
                "placeholder": "Caption"
            }).appendTo(pictureDiv);
            var spanButton = span.clone().attr({
                "class": "image-event-button",
                "data-type": "cover",
                "data-action": "remove",
                "data-id": image.id
            }).appendTo(pictureDiv);
            var inpHidden = input.clone().attr({
                "type": "hidden",
                "name": "image-cover",
                "value": image.id
            }).appendTo(pictureDiv);
            var spanIcon   = span.clone().attr({"class": "font-icon icon-cancel"}).appendTo(spanButton);
            var spanText   = span.clone().html(" " + Localize.getLocaleString("Remove image")).appendTo(spanButton);
            // Bind the button to do that stuff
            // you know you want it to do...
            spanButton.click(function () {
        		$.fn.imageEventClick($(this));
            });
        }
    }

    /**
     * Display the the images that
     * have been uploaded.
     *
     * @param   array   An array containing information on image
     */
    $.fn.createImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;

        var parent  = $("#dragzone-image").find("div.input");
        var div     = $("<div>");
        var img     = $("<img>");
        var span    = $("<span>");
        var input   = $("<input>");
        // Check if the container element exists
        var container = $("div.image-container");
        if (container.length < 1)
            container = div.clone().attr({
                "class": "image-container"
            }).appendTo(parent);
        // Create the picture
        var pictureDiv = div.clone().attr({
            "class"     : "picture",
            "data-id"   : image.id
        }).appendTo(container);
        var pictureBox = div.clone().attr({
            "class": "picture-box"
        }).appendTo(pictureDiv);
        var imgElement = img.clone().attr({"src": image.path}).appendTo(pictureBox);
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
        var spanText   = span.clone().html(" " + Localize.getLocaleString("Remove image")).appendTo(spanButton);
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
            $.fn.imageEventClick($(this));
        });

        // parent.find("img").remove();
        // parent.children().show();
    }

    $.fn.createCKEditorImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;
        // The container of the images
        var divContainer = $("#preview");
        // Create the image box
        var divPicture = $("<div>").attr({"class": "picture"}).appendTo(divContainer);
        var paragraph = $("<p>").html(Localize.getLocaleString("Click to insert image")).appendTo(divPicture);
        var image = $("<img>").attr({"src": image.path}).appendTo(divPicture);
        // Bind the image to send it to the ckeditor
        image.click(function () {
            var imageURL = $(this).attr("src");
            $.fn.insertImage(imageURL);
            window.close();
        });
        var parent = $("fieldset.image-ckeditor").find("div.dragzone");
        parent.find("img").remove();
        parent.children().show();
    }

    /**
     * Create a spinner image.
     *
     * @param   element The element to apply the image to
     */
    $.fn.createLoaderImage = function (element) {
        var loaderImage = $("<img>").attr({
            "src": "/public/images/system/loading-128.png",
            "class": "center-image"
        }).appendTo(element);
    }

    /**
     * Check if the extension matches.
     *
     * @param   string  Name of file
     */
    $.fn.checkExtension = function (fileName) {
        var extension       = fileName.split('.').pop().toLowerCase();
        var extensionArray  = ["jpg", "jpeg", "png", "gif"];
        if ($.inArray(extension, extensionArray) != -1)
            return true;
        return false;
    }
});
