$(document).ready(function() {

    $(".menu-bar-li").click(function () {
        var href = $(this).attr("data-href") || false;
        if (href !== false && href === "open:sub-menu") {
            var children = $(this).nextUntil(".menu-bar-li:not(.sub-menu)");
            children.slideToggle();
        } else if (href !== false) {
            window.location.href = href;
        }

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
