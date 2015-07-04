$(document).ready(function() {

    $("#splash").css({
        'opacity': 0
    }).animate({
        'opacity': 1
    },750);

    $("ul#list-menu > li").click(function () {
        var link = $(this).find("a").attr("href") || false;
        if (link !== false)
            window.location.href = link;
    });

    $.fn.createErrorMessage = function (message) {
		if ($("#errorMessage").length > 0) {
			var errorDiv = $("#errorMessage").append("<br/>" + message);
		} else {
			var errorDiv = $("<div>").attr("id", "errorMessage").append(message).appendTo("body");
			errorDiv.on("click", function () { $(this).remove(); });
		}
	}

    $(".image-event-button").click(function(e) {
		e.preventDefault();
console.log("OK");
		var type 	= $(this).attr("data-type") || false;
		var action 	= $(this).attr("data-action") || false;
		if (type === false || action === false)
			return null;

		$.fn.imageHandlerEvent(type, action);
	});

	$.fn.imagesHandlerEvent = function (type, action) {
		var type 	= type || false;
		var action 	= action || false;
		if (type === false || action === false)
			return null;
		// Get the elements within the parent,
		// sans the first child which should
		// be the legend label.
		var element = $("fieldset.image-"+type).children().not(":first-child");
		// Check which action was requested.
		if (action === "input") {
			// Remove the old, and create the new ones.
			element.remove();
			if (type === "cover")
				$.fn.createCoverImageElements(action, false);
		} else if (action === "upload") {
			// Check if the user has
			// selected a file.
			var fileName = $("input#image-"+type).val();
			if ($.fn.checkExtension(fileName) === false) {
				$.fn.createErrorMessage("Du m&aring;ste v&auml;lja en bild med r&auml;tt &auml;ndelse.");
				return false;
			}
			// Set the form and input file
			var file = document.getElementById("image-"+type).files[0];
			// Hide the children elements of
			// the input div and show the
			// loader image. Add the center
			// class so it looks better.
			element.children().hide();
			element.addClass("center");
			$.fn.createLoaderImage(element);
			// Create the Form Data object that
			// will send the data from file input.
			var data = new FormData();
			data.append("file", file);
			// Make the request
			$.fn.uploadImage(type, data, element);
		} else if (action === "remove") {
			var imageID = $("input[name='coverImage']").val();
			$.fn.removeImage("cover", imageID, element);
		}

	}

	// $.fn.createImageElements = function (type, params, extra) {
	// 	var type = type || false;
	// 	var params = params || false;
	// 	var extra = extra || false;
	// 	if (type === false || params === false)
	// 		return null;
	//
	// 	if (type === "cover") {
	// 		var masterDiv = $("<div>").hide();
	// 	} else if (type === "normal") {
	//
	// 	} else if (type === "ckeditor") {
	//
	// 	}
	//
	// }

	$.fn.createSlideshowImageElements = function (params) {
		var params = params || false;
		if (params === false)
			return null;

		var parentDiv 	= $("<div>").attr({"class": "image-normal"}).hide();
		var imageDiv	= $("<div>").appendTo(parentDiv);
		var image		= $("<img>").attr({"src": params.path}).appendTo(imageDiv);
		var secondDiv	= $("<div>").appendTo(parentDiv);
		var caption		= $("<input>").attr({"type": "text", "name": "caption[]"}).appendTo(secondDiv);
		var hiddenInput = $("<input>").attr({"type": "hidden", "name": "images[]", "value": params.id}).appendTo(secondDiv);
		var remove		= $("<p>").attr({"class": "image-event-button", "data-action": "remove", "data-type": "normal"}).html("Ta bort").appendTo(secondDiv);

		remove.click(function() {
			$.fn.imageHandlerEvent("normal", "remove");
		});

		var fieldset = $("fieldset.image-normal-showcase");
		parentDiv.appendTo(fieldset).fadeIn();
	}

	$.fn.createCoverImageElements = function (action, params) {
		var params 	= params || false;
		var div 	= $("<div>").hide();

		if (action === "input") { // Create the file input element for uploading
			var desc 	= $("<p>").html("Omslagsbilden syns p&aring; l&ouml;pet. F&ouml;r b&auml;sta upplevelse b&ouml;r den vara 700 pixlar bred.").appendTo(div);
			var input 	= $("<input>").attr({"type": "file", "id": "image-cover", "name": "file"}).appendTo(div);
			var button	= $("<button>").attr({"class": "image-event-button", "data-action": "upload", "data-type": "cover"}).html("Ladda upp").appendTo(div);

			button.click(function(event) {
				event.preventDefault();
				$.fn.imageHandlerEvent("cover", "upload");
			});

			div.attr({"class": "image-cover-input"});
		} else if (action === "upload") {
			var img 	= $("<img>").attr({"src": params.path}).appendTo(div);
			var desc	= $("<p>").attr({"class": "image-event-button", "data-action": "remove", "data-type": "cover"}).html("Ta bort omslagsbild").appendTo(div);
			var input 	= $("<input>").attr({"type": "hidden", "id": "image-cover", "name": "image-cover", "value": params.id}).appendTo(div);

			desc.click(function() {
				$.fn.imageHandlerEvent("cover", "remove");
			});

			div.attr({"class": "image-cover"});
		} else if (action === "remove") {
			var spanButtonUpload = $("<span>").attr({"class": "image-event-button", "data-action": "input", "data-type": "cover"}).html("Ladda upp egen bild");
			var spanButtonGallery = $("<span>").attr({"class": "image-event-button", "data-action": "gallery"}).html("V&auml;lj fr&aring;n bildgalleriet");
			var middleSectionText = $("<p>").html("eller");

			spanButtonUpload.click(function() {
				$.fn.imageHandlerEvent("cover", "input");
			});

			div.attr("class", "image-cover").append(spanButtonUpload).append(middleSectionText).append(spanButtonGallery);
		}

		var fieldset = $("fieldset.image-cover");
		div.appendTo(fieldset).fadeIn();
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
