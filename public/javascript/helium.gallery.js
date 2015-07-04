$(document).ready(function($) {

	$.fn.getURLParam = function (paramName) {
		var regex = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
		var match = window.location.search.match(regex);

		return (match && match.length > 1) ? match[1] : "";
	}

	$.fn.insertImage = function (imageURL) {
		var imageURL = imageURL || "";
		var functionNumber = $.fn.getURLParam("CKEditorFuncNum");
		window.opener.CKEDITOR.tools.callFunction(functionNumber, imageURL);
	}

	$("div.image-item").not(".header").click(function () {
		var imageURL = $(this).attr("data-src");
		$.fn.insertImage(imageURL);
		window.close();
	});

});
