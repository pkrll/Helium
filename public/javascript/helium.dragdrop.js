$(document).ready(function($) {

    $.fn.bindDragEvents = function () {
        this.on("dragenter", function (event) { $.fn.dragEnter(event, $(this)); });
        this.on("dragover", function (event) { $.fn.dragOver(event); });
        this.on("drop", function (event) { $.fn.drop(event, $(this)); });
        this.on("dragleave", function (event) { $.fn.dragLeave (event); });
    }

    $("fieldset.dragzone").bindDragEvents();

    $.fn.dragEnter = function (event, element) {
        var element = element || false;
        if (element !== false)
            element.addClass("highlight");
        $.fn.dragAndDrop(event);
    }

    $.fn.dragOver = function (event, element) {
        var element = element || false;
        if (element !== false)
            element.removeClass("highlight");
        $.fn.dragAndDrop(event);
    }

    $.fn.dragLeave = function (event, element) {
        var element = element || false;
        if (element !== false)
            element.removeClass("highlight");
        $.fn.dragOver(event);
    }

    $.fn.drop = function (event, element) {
        var element = element || false;
        if (element !== false)
            var type = element.attr("data-type");
		$("fieldset.dragzone").removeClass("highlight");
		$.fn.dragAndDrop(event, "upload", type);
    }

	$(document).on("dragenter", function (event) { $.fn.dragEnter(event); });
	$(document).on("drop", function (event) { $.fn.drop(event); });
	$(document).on("dragover", function (event) { $.fn.dragOver(event, $("fieldset.dragzone")); });

	$.fn.dragAndDrop = function (event, action, type) {
		var action = action || false;
        var type = type || false;
		// Check which action was requested
		if (action === false || type == false) {
			// Default. Stop everything!
			event.stopPropagation();
			event.preventDefault();
		} else if (action === "upload") {
			// Get the files that got dropped
			// on the #dragzone, sort through
			// and ignore the non-image files.
			var files = event.originalEvent.dataTransfer.files;
            var error = false;
			var formData = new FormData();
			$.each(files, function(x, file) {
				if ($.fn.checkExtension(file.name) === false) {
					$.fn.createErrorMessage("Du m&aring;ste v&auml;lja en bild med r&auml;tt &auml;ndelse.");
                    error = true;
					return false;
				} else {
					// Create the FormData to send
					formData.append('file'+x, file);
				}

                if (type === "cover")
                    return false;
			});
            if (error)
                return false;
			// Create the container for the progressbar
			var element = $("<div>").attr({
                "id": "progress-bar-container"
            }).css({
                "left": (($(window).width() / 2) - (200/2))
            }).appendTo("body");
			// Create the progress bar before sending
			var statusbar = new ProgressBar ({
				color: "#000",
				parentElement: element
			});
			statusbar.createBar();
			$.fn.send(formData, type, files.length, statusbar);
		}
	}

	$.fn.send = function (dataPackage, type, packageSize, progressBar) {
		var dataPackage = dataPackage || false;
		var packageSize = packageSize || false;
		var progressBar = progressBar || false;
		if (dataPackage === false || packageSize === false || progressBar === false)
			return false;
		// Set type of image uploading,
		// for the server to know.....
        var type = type || false;
		// Create the XHR Request.
		var xhr = new XMLHttpRequest();
		// These are for onprogress
		// monitoring the stream.
		xhr.previousBuffer = "";
		xhr.loaded = 0;
		xhr.total = packageSize;
		// Upload.onprogress will monitor
		// the progress of the upload to
		// the server.
		xhr.upload.onprogress = function (event) {
			var completed = 0;
			if (event.lengthComputable) {
				var completed = Math.round((event.loaded / event.total * 1000) / 10 / 2);
				progressBar.setProgress(completed);
			}
		}
		// Onprogress will monitor the
		// image resizing being done.
		xhr.onprogress = function (event) {
			// The stream will be buffered
			// and contains the old response
			// as well. Cut out the latest
			// part and show the image.
			var response = event.currentTarget.response;
			var contents = response.substring(xhr.previousBuffer.length);
			var completed = (Math.round((++xhr.loaded / xhr.total * 1000) / 10 / 2) + progressBar.getProgress());
			progressBar.setProgress(completed);
			xhr.previousBuffer = response;
            if (type == "ckeditor" || type == "slideshow") {
                try {
    				var image = jQuery.parseJSON(contents);
                    if (image.error) {
                        $.fn.createErrorMessage(Localize.getLocaleString(image.error.message));
                    } else {
                        if (type == "ckeditor")
        				    $.fn.createCKEditorImageElement (image);
                        else
                            $.fn.createSlideshowImageElement (image);
                    }
    			} catch (e) {
                    $.fn.createErrorMessage(Localize.getLocaleString("Error:") + "\n" + e);
                    console.log(contents);
    			}
            }
		}

		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
                if (type == "cover") {
                    try {
                        var image = jQuery.parseJSON(xhr.responseText);
                        $.fn.imageHandlerEvent (type, "uploaded", image);
                    } catch (e) {
                        $.fn.createErrorMessage(Localize.getLocaleString("Error:") + "\n" + e);
                        console.log("Error:" + e + "\n" + xhr.responseText);
                    }
                }

                $("#progress-bar-container").remove();
			}
		}

		xhr.open('POST', '/upload/image/'+type+'/stream');
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.send(dataPackage);

	}


});
