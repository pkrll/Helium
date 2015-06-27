$(document).ready(function() {

    $("#splash").css({
        'opacity': 0
    }).animate({
        'opacity': 1
    },750);

    $("ul#list-menu > li").click(function() {
        var link = $(this).find("a").attr("href") || false;
        if (link !== false)
            window.location.href = link;
    });

    $("input[type=submit]").click(function(event) {
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
