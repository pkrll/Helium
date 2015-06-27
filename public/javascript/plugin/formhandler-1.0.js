(function ($) {

    var formError = {
        'FIELD_EMPTY'   : "Please fill out this field.",
        'TYPE_NUMBER'   : "Only numbers are allowed."
    }

    jQuery.fn.FormHandler = function () { }

    jQuery.fn.FormHandler.createErrorMessage = function (errorType, element) {
        var errorDiv = null;
        if (errorType === 'FIELD_EMPTY') {
            errorDiv = $("<div>").attr({
                "class": "error"
            }).html(formError[errorType]);
        }

        return errorDiv;
    }

    jQuery.fn.FormHandler.removeErrorMessages = function () {
        $("body").find("form#article div.error").remove();
    }

})(jQuery);
