
$(document).ready(function($) {

    /**
     * Small plugin function that binds
     * the drag events to an element.
     */
    // $.fn.bindDragEvents = function () {
    //     this.on("dragenter", function (event) { $.fn.dragEnter(event, $(this)); });
    //     this.on("dragover", function (event) { $.fn.dragOver(event); });
    //     this.on("drop", function (event) { $.fn.drop(event, $(this)); });
    //     this.on("dragleave", function (event) { $.fn.dragLeave (event); });
    // }

    // Run the below function on start
//    $("fieldset.dragzone").bindDragEvents();






    /**
     * Determines if the drag/drop was valid
     * and creates a formData object to send
     * to the method Send().
     *
     * @param eventTarget
     * @param String The type of action requested
     * @param String The type of object being dropped
     */
	$.fn.dragAndDrop = function (event, action, type) {
		var action = action || false;
        var type = type || false;
		// Check what action was requested
		if (action === false || type == false) {
			// Default: Stop everything!
			event.stopPropagation();
			event.preventDefault();
		} else if (action === "upload") {
			// Get the files that got dropped
			// on the drop target, sort through
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
                // Cover images can not be sent in
                // bulk. Only one cover per article.
                if (type === "cover")
                    return false;
			});
            // Quit the script if an error was detected
            if (error)
                return false;
            var statusbar = $.fn.createStatusBar();
            // Send the dropped files.
			$.fn.sendDroppedFiles(formData, type, files.length, statusbar);
		}
	}

    /**
     * Creates a ProgressBar object
     * that will monitor the upload
     * progress of files that's been
     * uploaded through drag an drop.
     *
     * @returns ProgressBar
     */
    $.fn.createStatusBar = function() {
        // Create the container for the progressbar
        var element = $("<div>").attr({
            "id": "progress-bar-container"
        }).appendTo("body");
        // Create the progress bar object
        var statusbar = new ProgressBar ({
            parentElement: element
        });
        statusbar.createBar();

        return statusbar;
    }

    $.fn.sendDroppedFiles = function (dataPackage, type, packageSize, progressBar) {
		var dataPackage = dataPackage || false;
		var packageSize = packageSize || false;
		var progressBar = progressBar || false;
		if (dataPackage === false || packageSize === false || progressBar === false)
			return false;
		// Set type of image uploading,
		// for the server to know.....
        var type = type || false;
		// Time for the request
		var xhr = new XMLHttpRequest();
		// These are for onprogress
		// monitoring the "stream".
		xhr.previousBuffer = "";
		xhr.loaded = 0;
		xhr.total = packageSize;
		// Upload.onprogress will monitor
		// the progress of the upload to
		// the server.
		xhr.upload.onprogress = function (event) {
			var completed = 0;
			if (event.lengthComputable) {
                // The status is divided by two beacuse
                // this part is dedicated to the actual
                // uploading process. But the server also
                // does stuff to the image, which can take
                // some time.
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
            // Set the progress bar status. Divided
            // by two, because the first 50% is dedicated
            // to the actual uploading process, the rest
            // to the time it takes the server to resize
            // the images and send the information back.
			var completed = (Math.round((++xhr.loaded / xhr.total * 1000) / 10 / 2) + progressBar.getProgress());
			progressBar.setProgress(completed);
			xhr.previousBuffer = response;
            // Only CKEditor and slideshow images should
            // be subject to streaming, because there can
            // be only one cover image.
            if (type == "ckeditor" || type == "slideshow") {
                // Nasty fix for streaming bug that occurs
                // when the server sends the JSON encoded
                // strings all at once, which means that
                // the JSON array is actually just a string.
                // Stream array will place a newline between
                // the } {-brackets and then split the string
                // by the newline, making it an array again.
                var streamArray = contents.replace(/(\}([\s\S]*?)\{)/gi, "}\n{");
                streamArray = streamArray.split("\n");
                try {
                    // If it is an array, then loop through
                    // it and analyze the values.
                    if (streamArray.length > 0) {
                        $.each(streamArray, function (i, content) {
                            // Make sure it's not empty...
                            if (content.length > 0) {
                                var image = jQuery.parseJSON(content);
                                // Check for errors
                                console.log(image);
                                if (image.error) {
                                    $.fn.createErrorMessage (Localize.getLocaleString (image.error.message));
                                } else {
                                    if (type == "ckeditor")
                                        $.fn.createCKEditorImageElement (image);
                                    else
                                        $.fn.createSlideshowImageElement (image);
                                }
                            }
                        });
                    }
    			} catch (e) {
                    $.fn.createErrorMessage (Localize.getLocaleString("Error:") + "\n" + e);
                    console.log(e);
    			}
            }
		}
        // When the process is through, show the
        // image. This is only for cover images,
        // seeing as the other images "stream" on
        // drag and drop.
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
                if (type == "cover") {
                    try {
                        var image = jQuery.parseJSON(xhr.responseText);
                        if (image.error) {
                            $.fn.createErrorMessage (Localize.getLocaleString (image.error.message));
                        } else {
                            $.fn.imageHandlerEvent (type, "display", image);
                        }
                    } catch (e) {
                        $.fn.createErrorMessage (Localize.getLocaleString ("Error:") + "\n" + e);
                        console.log("Error:" + e + "\n" + xhr.responseText);
                    }
                }
                // Remove the progress bar when done.
                $("#progress-bar-container").remove();
			}
		}
        // POST data to below URL, and go send!
		xhr.open('POST', '/upload/image/'+type+'/stream');
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.send(dataPackage);
	}

});
