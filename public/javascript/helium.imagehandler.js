$(document).ready(function() {

    $(".image-event-button").click(function(e) {
		e.preventDefault();
		$.fn.imageEventClick($(this));
	});

    $.fn.imageEventClick = function (element) {
        var type    = element.attr("data-type") || false;
        var action  = element.attr("data-action") || false;
        if (type === false || action === false)
			return null;
        // FIRE!
		$.fn.imageHandlerEvent(type, action);
    }

    $.fn.imageHandlerEvent = function (type, action, image) {
        var type = type || false;
        var action = action || false;
        var image = image || false;
        if (type === false || action === false)
            return null;
        // Action: Upload image
        if (action === "upload") {
            // Get all the elements within the
            // fieldset, but not the first one
            // which should be the legend elem
            var parent = $("fieldset.image-"+type).find("div.dragzone");
            var elements = parent.children();
            // Check the selection
            var fileName = $("input#image-"+type).val();
            if ($.fn.checkExtension(fileName) === false) {
                $.fn.createErrorMessage(Localize.getLocaleString("You can only upload images"));
                return false;
            }

            var file = document.getElementById("image-"+type).files[0];
            // Hide the child elements
            // of the fieldest and set
            // the loadimage spinning.
            elements.hide();
            $.fn.createLoaderImage(parent);
            // Create the FormData object
            // and call upload function.
            var data = new FormData();
            data.append("file", file);
            $.fn.uploadImage(type, data, parent);
        } else if (action === "uploaded") {
            // Get all the elements within the
            // fieldset, but not the first one
            // which should be the legend elem
            // var parent = $("fieldset.image-"+type).find("div.dragzone");
            // var elements = parent.children();
            // parent.find("img").remove();
            if (type === "cover") {
                $.fn.createCoverImageElement(image, null);
            } else {
                if (type ==="ckeditor") {
                    $.fn.createCKEditorImageElement(image);
                } else {
                    $.fn.createSlideshowImageElement(image);
                }
            }
        } else if (action === "remove") {
            var imageID = $("input[name='image-"+type+"']").val();
			// var remove  = $.fn.removeImage(type, imageID);
            var remove = true;
            if (remove === true) {
                $.fn.createCoverImageElement(null, "remove");
            }
        }
    }

    $.fn.createSlideshowImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;
        var parent = $("fieldset.image-slideshow");
        if (parent.find("div.picture-box-container").length > 0) {
            var divContainer = $("fieldset.image-slideshow div.picture-box-container");
        } else {
            var divContainer = $("<div>").attr({
                "class": "picture-box-container"
            }).appendTo(parent);
        }

        var divPicBox = $("<div>").attr({
            "class": "picture-box"
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
        var spanButton = $("<span>").attr({
            "class": "image-event-button",
            "data-type": "slideshow",
            "data-action": "remove"
        }).html(Localize.getLocaleString("Remove picture")).appendTo(divCaption);
        var divInput = $("<div>").appendTo(divCaption);
        var input = $("<input>").attr({
            "type": "text"
        }).appendTo(divInput);
        var parent = $("fieldset.image-slideshow").find("div.dragzone");
        parent.find("img").remove();
        parent.children().show();
    }

    $.fn.createCKEditorImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;
        // Create the preview element
        var div = $("<div>").attr({
            "class": "preview"
        });
        var fieldset = $("<fieldset>").attr({
            "class": "image-ckeditor-showcase"
        }).appendTo(div);
        var description = $("<p>").html(Localize.getLocaleString("Click to insert image")).appendTo(fieldset);
        var image = $("<img>").attr({
            "src": image.path,
            "id": "CKEditorImage"
        }).appendTo(fieldset);
        // Bind click function
        image.click(function () {
            var imageURL = $(this).attr("src");
            $.fn.insertImage(imageURL);
            window.close();
        });

        var parent = $("fieldset.image-ckeditor").find("div.dragzone");
        parent.find("img").remove();
        parent.children().show();
        // Add it to the page
        div.appendTo($("div#upload"));
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
            var parent = fieldset.find("div.cover");
            parent.remove();
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
            }).html("Upload").appendTo(browseBox);
            var galleryBox = $("<div>").attr({"class": "gallery-box"}).appendTo(dragzone);
            var galleryLink = $("<span>").html(Localize.getLocaleString("Choose from gallery")).appendTo(galleryBox);
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
            // you want it to do, you know...
            spanButton.click(function () {
        		$.fn.imageEventClick($(this));
            });
            // add it to the fieldset
            pictureBox.appendTo(fieldset);
        }
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
