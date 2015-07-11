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
              type    = element.attr("data-type") || false;
        if (type === false || action === false)
			return null;
        // FIRE!
    	$.fn.imageHandlerEvent(type, action);
    }

    /**
     * Handles the image events. Calls the
     * upload function, or element creation.
     *
     * @param String The type of image
     * @param String Action requested
     * @param Array Contains the path and id of the image
     */
    $.fn.imageHandlerEvent = function (type, action, image) {
        var action = action || false,
             image = image || false,
              type = type || false;
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
            var imageID = $("input[name='image-"+type+"']").val();
            // var remove = $.fn.removeImage(type, imageID);
            var remove = true;
            if (remove === true) {
                $.fn.removeImageElements(type, imageID);
            }
        }
    }

    $.fn.removeImageElements = function (type, imageID) {
        var imageID = imageID || false,
               type = type || false;
        if (type === false)
            return false;
        if (type === "cover") {
            $.fn.createCoverImageElement(null, "remove");
        } else if (type === "slideshow") {

            $("div#"+imageID).remove();
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
        var image = image || false;
        var action = action || false
        if (action !== "remove" && image === false)
            return false;
        var fieldset = $("fieldset.image-cover");

        if (action === "remove") {
            // Remove the image element
            // and rebind the drag events
            var cover = fieldset.find("div.cover");
            cover.remove();
            fieldset.addClass("dragzone").bindDragEvents();
            // Create the elements
            var dragzone = $("<div>").attr({"class": "dragzone"});
            var description = $("<div>").html(Localize.getLocaleString("Upload image by dragging it onto this field, or use the button below.")).appendTo(dragzone);
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
                "class": "font-icon menu icon-gallery"
            });
            var galleryLink = $("<span>").attr({
                "class": "gallery"
            }).append(galleryIcon).append(Localize.getLocaleString("Choose from gallery")).appendTo(galleryBox);
            // Bind the button to do that stuff
            // you want it to do, you know...
            button.click(function (e) {
                e.preventDefault();
        		$.fn.imageEventClick($(this));
            });
            // Add it all to the fieldset
            dragzone.appendTo(fieldset);
        } else {
            // Remove the old elements and
            // unbind all drag events.
            fieldset.find("div.dragzone").remove();
            fieldset.removeClass("dragzone");
            fieldset.unbind('dragenter dragover drop');
            // Create the elements that will
            // hold the uploaded image.
            var pictureBox = $("<div>").attr({"class": "picture-box cover"});
            var pictureImg = $("<div>").attr({"class": "picture"}).appendTo(pictureBox);
            var imgElement = $("<img>").attr({"src": image.path}).appendTo(pictureImg);
            var divCaption = $("<div>").attr({"class": "caption"}).appendTo(pictureBox);
            var divElement = $("<div>").appendTo(divCaption);
            var inpCaption = $("<input>").attr({
                "type": "text",
                "name": "caption-cover",
                "placeholder": "Caption"
            }).appendTo(divElement);
            var inpHidden = $("<input>").attr({
                "type": "hidden",
                "name": "image-cover",
                "value": image.id
            }).appendTo(divElement);
            var divElement = $("<div>").appendTo(divCaption);
            var spanButton = $("<span>").attr({
                "class": "image-event-button",
                "data-type": "cover",
                "data-action": "remove"
            }).html(Localize.getLocaleString("Remove image")).appendTo(divElement);
            // Bind the button to do that stuff
            // you know you want it to do...
            spanButton.click(function () {
        		$.fn.imageEventClick($(this));
            });
            // add it to the fieldset
            pictureBox.appendTo(fieldset);
        }
    }

    $.fn.createSlideshowImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;
        var parent = $("fieldset.image-slideshow");
        if (parent.find("div.picture-box-container").length > 0)
            var divContainer = $("div.picture-box-container");
        else
            var divContainer = $("<div>").attr({"class": "picture-box-container"}).appendTo(parent);
        // Create the picture box
        var divPicBox = $("<div>").attr({
            "class": "picture-box",
            "id": image.id
        }).appendTo(divContainer);
        var divPicElm = $("<div>").attr({
            "class": "picture"
        }).appendTo(divPicBox);
        var divPicImg = $("<img>").attr({
            "src": image.path
        }).appendTo(divPicElm);
        var divCaption = $("<div>").attr({
            "class": "caption"
        }).appendTo(divPicBox);
        var spanTrash = $("<span>").attr({
            "class": "font-icon icon-trash"
        });
        var spanButton = $("<span>").attr({
            "class": "image-event-button",
            "data-type": "slideshow",
            "data-action": "remove"
        }).append(spanTrash).append(Localize.getLocaleString("Remove image")).appendTo(divCaption);
        var divInput = $("<div>").appendTo(divCaption);
        var input = $("<input>").attr({
            "type": "text"
        }).appendTo(divInput);
        var inpHidden = $("<input>").attr({
            "type": "hidden",
            "name": "image-slideshow",
            "value": image.id
        }).appendTo(divInput);
        // Bind the button to do that stuff
        // you know you want it to do...
        spanButton.click(function () {
            $.fn.imageEventClick($(this));
        });
        var parent = $("fieldset.image-slideshow").find("div.dragzone");
        parent.find("img").remove();
        parent.children().show();
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
