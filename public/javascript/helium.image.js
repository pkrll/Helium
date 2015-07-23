$(document).ready(function() {

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
            var parent = $("fieldset.image-"+type).find("div.dragzone");
            var elements = parent.children();
            // Must check the selection
            var fileName = $("input#image-"+type).val();
            if ($.fn.checkExtension(fileName) === false) {
                $.fn.createErrorMessage(Localize.getLocaleString("You can only upload images"));
                return false;
            }
            var file = document.getElementById("image-"+type).files[0];
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
            // var remove = $.fn.removeImage(type, image);
            var remove = true;
            if (remove === true) {
                $.fn.removeImageElements(type, image, edit);
            }
        }
    }

    $.fn.removeImageElements = function (type, imageID, edit) {
        var imageID = imageID || false,
               type = type || false,
               edit = edit || false;
        if (type === false)
            return false;

        if (edit === "true") {
            var parentElement   = $("form#article");
            var removedImage    = $("<input>").attr({
                "type": "hidden",
                "value": imageID,
                "name": "image-remove[]"
            }).appendTo(parentElement);
        }

        if (type === "cover") {
            $.fn.createCoverImageElement(null, "remove");
        } else if (type === "slideshow") {
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
        } else {
            if (type === "ckeditor") {
                $.fn.createCKEditorImageElement(image);
            } else {
                $.fn.createSlideshowImageElement(image);
            }
        }
    }

    $.fn.createCoverImageElement = function (image, action) {
        var action = action || false,
             image = image || false;
        if (action !== "remove" && image === false)
            return false;

        var parent = $("div.right.picture-box");

        if (action === "remove") {
            // Remove the image element
            // and rebind the drag events
            var cover = parent.find("div.picture");
            cover.remove();
            // Create the new elements
            var fieldset = $("<fieldset>").attr({
                "class": "dragzone right image-cover",
                "data-type": "cover"
            }).appendTo(parent);
            fieldset.bindDragEvents();
            var dragzone = $("<div>").attr({"class": "dragzone"});
            var description = $("<div>").html(Localize.getLocaleString("Upload image by dragging it onto this field, or use the options below.")).appendTo(dragzone);
            var browseBox = $("<div>").attr({"class": "browse-box"}).appendTo(dragzone);
            var inputFile = $("<input>").attr({
                "type": "file",
                "id": "image-cover"
            }).appendTo(browseBox);
            var button = $("<button>").attr({
                "class": "image-event-button",
                "data-type": "cover",
                "data-action": "upload"
            }).html(Localize.getLocaleString("Upload")).appendTo(browseBox);
            var galleryBox = $("<div>").attr({"class": "gallery-box"}).appendTo(dragzone);
            var galleryIcon = $("<span>").attr({
                "class": "font-icon icon-gallery"
            });
            var galleryLink = $("<span>").attr({
                "class": "gallery"
            }).append(galleryIcon).append(" " + Localize.getLocaleString("Choose from gallery")).appendTo(galleryBox);
            // Bind the button to do that stuff
            // you want it to do, you know...
            button.click(function (e) {
                e.preventDefault();
        		$.fn.imageEventClick($(this));
            });
            // Add it all to the fieldset
            dragzone.appendTo(fieldset);
        } else {
            // Remove the old elements
            parent.find("fieldset.dragzone").remove();
            // Create the div to clone
            var div     = $("<div>");
            var span    = $("<span>");
            var input   = $("<input>");
            // Create the elements that will
            // hold the uploaded image.
            var pictureBox = div.clone().attr({"class": "picture"});
            var pictureDiv = div.clone().attr({"class": "picture-container"}).appendTo(pictureBox);
            var imgElement = $("<img>").attr({"src": image.path}).appendTo(pictureDiv);
            var captionDiv = div.clone().attr({"class": "caption"}).appendTo(pictureBox);
            var divElement = div.clone().appendTo(captionDiv);
            var inpCaption = input.clone().attr({
                "type": "text",
                "name": "caption-cover",
                "placeholder": "Caption"
            }).appendTo(divElement);
            var inpHidden = input.clone().attr({
                "type": "hidden",
                "name": "image-cover",
                "value": image.id
            }).appendTo(divElement);
            var divElement = div.clone().appendTo(captionDiv);
            var spanButton = span.clone().attr({
                "class": "image-event-button",
                "data-type": "cover",
                "data-action": "remove",
                "data-id": image.id
            }).appendTo(divElement);
            var spanIcon   = span.clone().attr({
                "class": "font-icon icon-cancel"
            }).appendTo(spanButton);
            var spanText   = span.clone().html(" " + Localize.getLocaleString("Remove image")).appendTo(spanButton);
            // Bind the button to do that stuff
            // you know you want it to do...
            spanButton.click(function () {
        		$.fn.imageEventClick($(this));
            });
            // add it to the fieldset
            pictureBox.appendTo(parent);
        }
    }

    $.fn.createSlideshowImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;

        var parent  = $("div.left.picture-box");
        var div     = $("<div>");
        var span    = $("<span>");
        var input   = $("<input>");
        // Create the picture box
        var pictureBox = div.clone().attr({
            "class": "picture",
            "data-id": image.id
        }).appendTo(parent);
        var divPicture = div.clone().attr({"class": "picture-container"}).appendTo(pictureBox);
        var imgElement = $("<img>").attr({
            "src": image.path
        }).appendTo(divPicture);
        var divCaption = div.clone().attr({"class": "caption"}).appendTo(pictureBox);
        var spanButton = span.clone().attr({
            "class": "image-event-button",
            "data-type": "slideshow",
            "data-action": "remove",
            "data-id": image.id
        }).appendTo(divCaption);
        var spanTrash  = span.clone().attr({
            "class": "font-icon icon-cancel"
        }).appendTo(spanButton);
        var spanText   = span.clone().html(" " + Localize.getLocaleString("Remove image")).appendTo(spanButton);
        var divInput   = div.clone().appendTo(divCaption);
        var inpText    = input.clone().attr({
            "type": "text",
            "name": "caption-slideshow[]",
            "placeholder": "Caption"
        }).appendTo(divInput);
        var inpHidden  = input.clone().attr({
            "type": "hidden",
            "name": "image-slideshow[]",
            "value": image.id
        }).appendTo(divInput);
        // Bind the button to do that stuff
        // you know you want it to do...
        spanButton.click(function () {
            $.fn.imageEventClick($(this));
        });
        var fieldset = $("fieldset.image-slideshow").find("div.dragzone");
        fieldset.find("img").remove();
        fieldset.children().show();
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

    $.fn.createLoaderImage = function (element) {
        var loaderImage = $("<img>").attr({
            "src": "/public/images/system/loading-128.png",
            "class": "center-image"
        }).appendTo(element);
    }

    $.fn.checkExtension = function (fileName) {
        extension = fileName.split('.').pop().toLowerCase();
        if ($.inArray(extension, ['jpg']) != -1 || $.inArray(extension, ['jpeg']) != -1 || $.inArray(extension, ['png']) != -1
        || $.inArray(extension, ['gif']) != -1) {
            return true;
        } else {
            return false;
        }
    }

});
