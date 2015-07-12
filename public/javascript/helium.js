$(document).ready(function() {
    // initialize localize plugin
    Localize = new Localize({
        "lang": "sv"
    });

    $.fn.createErrorMessage = function (message) {
		if ($("#errorMessage").length > 0) {
			var errorDiv = $("#errorMessage").append("<br/>" + message);
		} else {
			var errorDiv = $("<div>").attr("id", "errorMessage").append(message).appendTo("body");
			errorDiv.on("click", function () { $(this).remove(); });
		}
	}
});
