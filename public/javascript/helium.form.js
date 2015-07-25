$(document).ready(function() {
    // Safari does not fully support the HTML5
    // attribute 'required' as does Chrome and
    // Firefox. Check if the form elements are
    // filled before submitting the form.
    $("input[type='submit']").click(function (event) {
        if ($.fn.Browser.safari()) {
            // Prevent the submit. For now.
            event.preventDefault();
            var emptyElements = [];
            // Gather all the elements marked with
            // the 'required' attribute.
            var requiredElements = $('input,textarea,select').filter('[required]:visible')
            $.each(requiredElements, function(index, element) {
                if ($(element).val() === '')
                    emptyElements.push($(element));
            });
            // If one of the required elements is
            // empty throw an error and cancel the
            // form submit.
            if (emptyElements.length > 0) {
                var tooltip = new Tooltip({
                    "color": "#DE1212",
                    "label": "Please fill out this field",
                    "fadeOut": 5000,
                    "element": emptyElements[0].parent()
                }, true);
                $(".submit-error").html(Localize.getLocaleString("Please fill out the required fields"));
                $('html, body').animate({
                    scrollTop: emptyElements[0].parent().offset().top-100
                }, 500);
                // // No need to continue if we have
                // // found an error.
                return false;
            } else {
                // Must also check the CKEditor (abides
                // by other rules, you see...)
                // var body = CKEDITOR.instances.preamble.getData();
                // if (body.length == 0) {
                //
                // }
                // If all checks out, submit the
                // damned form, already!
                $("form").submit();
            }
        }
    });
});
