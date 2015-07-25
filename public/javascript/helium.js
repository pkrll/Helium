$(document).ready(function() {
    // initialize localize plugin
    Localize = new Localizer({
        "lang": "sv"
    });

    $.fn.createErrorMessage = function (message) {
        var div = $("<div>");
        var modalWindow = div.clone().attr({"class": "modal-window"});
        var modalHeader = div.clone().attr({"class": "modal-window-header"}).appendTo(modalWindow);
        var warningIcon = div.clone().attr({"class": "font-icon icon-attention"}).appendTo(modalHeader);
        var modalBody   = div.clone().attr({"class": "modal-window-body"}).html("An error has occured: " + message).appendTo(modalWindow);
        var modalFooter = div.clone().attr({"class": "modal-window-footer"}).appendTo(modalWindow);
        var divButton   = div.clone().attr({"class": "modal-window-button dismiss"}).html("OK").appendTo(modalFooter);
        divButton.on("click", function() {
            $(this).parent().parent().remove();
        });
        modalWindow.appendTo("body");
    }
});
