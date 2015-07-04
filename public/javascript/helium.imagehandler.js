$(document).ready(function() {

    $.fn.imageHandlerEvent = function (type, action, image) {
        var type = type || false;
        var action = action || false;
        var image = image || false;
        if (type === false || action === false)
            return null;
        // Get all the elements within the
        // fieldset, but not the first one
        // which should be the legend elem
        var parent = $("fieldset.image-"+type).find("div#dragzone");
        var elements = parent.children();
        // Action: Upload image
        if (action === "upload") {
            // Check the selection
            var fileName = $("input#image-"+type).val();
            if ($.fn.checkExtension(fileName) === false) {
                $.fn.createErrorMessage("You can only upload images.");
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
            parent.find("img").remove();
            if (type === "cover") {
                //TODO: Remove dashed border
                //TODO: Add remove button
                $.fn.createCoverImageElement(image);
            } else {
                parent.children().show();
                console.log(type);
                if (type ==="ckeditor")
                    $.fn.createCKEditorImageElement(image);
                else
                    $.fn.createSlideshowImageElement(image);
            }
        } else if (action === "remove") {

        }
    }

    $.fn.createSlideshowImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;
    }

    $.fn.createCKEditorImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;

        // If there already exists a
        // div#preview (for example if
        // the user already uploaded an
        // image), just switch it out.
        // if ($("div#preview").length > 0) {
        //     $("img#CKEditorImage").attr({
        //         "src": image.path
        //     });
        // } else {
            // Otherwise create the div
            // element holding the image.
            var div = $("<div>").attr({
                "class": "preview"
            });
            var fieldset = $("<fieldset>").attr({
                "class": "image-ckeditor-showcase"
            }).appendTo(div);
            var description = $("<p>").html("Click to insert image").appendTo(fieldset);
            var image = $("<img>").attr({
                "src": image.path,
                "id": "CKEditorImage"
            }).appendTo(fieldset);

            image.click(function () {
                var imageURL = $(this).attr("src");
                $.fn.insertImage(imageURL);
                window.close();
            })
        // }
        // Add it to the page
        div.appendTo($("div#upload"));
    }

    $.fn.createCoverImageElement = function (image) {
        var image = image || false;
        if (image === false)
            return false;

    }

});
