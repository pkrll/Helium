$(document).ready(function() {

	$.fn.uploadImage = function (type, data, element) {
		var type = type || false;
		var data = data || false;
		var element = element || false;
		if (data === false || type === false)
			return false;

		// Make the XMLHTTPRequest
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/upload/image/'+type);
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.onload = function() {
			// If the request succeeded
			if (xhr.status === 200) {
				var response = jQuery.parseJSON(xhr.responseText);
				if (response.error) {
					element.find("img").remove();
					element.children().show();
					$.fn.createErrorMessage(response.error.message);
				} else {
					$("input#image-"+type).val("");
					$.fn.imageHandlerEvent(type, "uploaded", response);
				}
			} else {
				element.find("img").remove();
				element.children().show();
				$.fn.createErrorMessage("Ett fel har intr&auml;ffat: status " + xhr.status);
			}

		}

		xhr.send(data);
	}

	$.fn.removeImage = function (type, imageID) {
		var type 	= type || false;
		var imageID = imageID || false;
		if (imageID === false || type === false)
			return false;

		if (type === "cover") {
			$.get("/upload/remove/"+imageID, function(rawdata) {
				// Parse data
				var response = jQuery.parseJSON(rawdata);
				// check for errors
				if (response.error) {
					$.fn.createErrorMessage("Ett fel har intr&auml;ffat: " + response.error.message);
					return false;
				} else {
					return true;
				}
			});
		}
	}

});
