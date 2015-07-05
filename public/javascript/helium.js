$(document).ready(function() {

    // initialize localize plugin
    Localize = new Localize({
        "lang": "sv"
    });

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

	

});
