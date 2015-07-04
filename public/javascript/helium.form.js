$(document).ready(function() {

    $("legend.section").click(function () {
        var elementsToHide = $(this).parent().children(':not(.section)');
        elementsToHide.toggle();
        if (elementsToHide.is(":hidden"))
            $(this).addClass("hidden");
        else
            $(this).removeClass("hidden");
    });

    $("div.button").click(function () {
        console.log($("#category").val());
    });

    $("div.add-input").click(function () {
        if ($(this).is(".headline")) {
            var parent = $(this).parent();
            var legend = $("<legend>").attr({
                "id": "small-headline"
            }).html("Small headline:").appendTo(parent);
            var input = $("<input>").attr({
                "type": "text",
                "name": "smallHeadline",
                "id": "small-headline",
                "autocomplete": "off",
                "required": "required"
            }).appendTo(parent);
            $(this).remove();
        } else {
            var input = $("<input>").attr({
                "type": "text",
                "name": "links[]",
                "placeholder": "Search for article..."
            }).insertBefore($(this));
        }
    });

    $("input[type=submit]").click(function (event) {
        // Safari does not fully support the HTML5
        // attribute 'required' as does Chrome and
        // Firefox, check if the form elements are
        // properly filled with this jQuery script.
        if ($.fn.Browser.safari()) {
            // Prevent the submit for now.
            event.preventDefault();
            var emptyElements = [];
            // Gather all the elements marked with
            // the 'required' attribute and check.
            var parent = $(this).parent();
            var requiredElements = parent.find("[required]");
            $.each(requiredElements, function(index, element) {
                if ($(element).val() === '')
                    emptyElements.push($(element));
            });
            // If one of the required elements is
            // empty throw an error and cancel the
            // form submit.
            if (emptyElements.length > 0) {
                // Remove the previous error messages
                // and the error styling of elements.
                $.fn.FormHandler.removeErrorMessages();
                $(".error").removeClass("error");
                // Add error styling to the element.
                emptyElements[0].addClass("error");
                // Create error message that will be
                // appended after the errored element.
                var errorDiv = $.fn.FormHandler.createErrorMessage('FIELD_EMPTY', emptyElements[0]);
                errorDiv.insertAfter(emptyElements[0]);
                // No need to continue if we have
                // found an error.
                return false;
            } else {
                // If all checks out, submit the
                // damned form, already!
                parent.submit();
            }
        }
    });
});
