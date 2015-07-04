$(document).ready(function($) {


    $("fieldset.dragzone").on("dragenter", function (event) {
		$(this).addClass("highlight");
		$.fn.dragAndDrop(event);
	});

	$("fieldset.dragzone").on("dragover", function (event) { $.fn.dragAndDrop(event); });

	$("fieldset.dragzone").on("drop", function (event) {
		$("fieldset.dragzone").removeClass("highlight");
		$.fn.dragAndDrop(event, "upload");
	});

	$(document).on("dragenter", function (event) { $.fn.dragAndDrop(event); });
	$(document).on("drop", function (event) { $.fn.dragAndDrop(event); });
	$(document).on("dragover", function (event) {
		$("fieldset.dragzone").removeClass("highlight");
		$.fn.dragAndDrop(event);
	});

	$.fn.dragAndDrop = function (event, action) {
		var action = action || false;
		// Check which action was requested
		if (action === false) {
			// Default. Stop everything!
			event.stopPropagation();
			event.preventDefault();
		} else if (action === "upload") {
			// Get the files that got dropped
			// on the #dragzone, sort through
			// and ignore the non-image files.
			var files = event.originalEvent.dataTransfer.files;
			var formData = new FormData();
			$.each(files, function(x, file) {
				if ($.fn.checkExtension(file.name) === false) {
					$.fn.createErrorMessage("Du m&aring;ste v&auml;lja en bild med r&auml;tt &auml;ndelse.");
					return false;
				} else {
					// Create the FormData to send
					formData.append('file'+x, file);
				}
			});

			// Create the container for the progressbar
			var element = $("<div>").attr({"id": "progress-bar-container"}).appendTo("div#upload");
			// Create the progress bar before sending
			var statusbar = new ProgressBar ({
				color: "#000",
				parentElement: element
			});
			statusbar.createBar();
			$.fn.send(formData, files.length, statusbar);

		}
	}

	$.fn.send = function (dataPackage, packageSize, progressBar) {
		var dataPackage = dataPackage || false;
		var packageSize = packageSize || false;
		var progressBar = progressBar || false;
		if (dataPackage === false || packageSize === false || progressBar === false)
			return false;
		// Set type of image uploading,
		// for the server to know.....
		var type = "CKEditor";
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

			try {
				var image = JSON.parse(contents);
				$.fn.createCKEditorImageElement(image);
			} catch (e) {
				console.log(e);
			}

		}

		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				// DO SOME
			}
		}

		xhr.open('POST', '/upload/image/'+type+'/stream');
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.send(dataPackage);

	}


});
