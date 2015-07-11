$(document).ready(function() {

    /**
     * Show/hide the right side sections.
     * Triggers when the user clicks on
     * the section labels.
     */
    $(".section-label").click(function () {
        var elementsToHide = $(this).parent().children(':not(.section-label)');
        elementsToHide.toggle();
    });

    /**
     * Add new input text fields.
     * User triggered.
     */
    $(".add-input").click(function() {
        // Get the information provided
        // inside the triggering element.
        var id = $(this).attr("data-id") || false;
        var type = $(this).attr("data-type") || false;
        var name = $(this).attr("data-name") || false;
        var remove = $(this).attr("data-remove") || false;
        var legend = $(this).attr("data-legend") || false;
        var required = $(this).attr("data-required") || false;
        var placeholder = $(this).attr("data-placeholder") || false;
        if (type === false || name === false)
            return false;
        // Create the label, if requested,
        // that will sit above the new input.
        var parent = $(this).parent();
        if (legend !== false) {
            var legend = $("<legend>").attr({ "id": name }).html(legend).insertBefore($(this));
        }
        // Create the input with the values
        // provided by the triggering element.
        var input = $("<input>").attr({
            "type": type,
            "name": name,
            "autocomplete": "off"
        });
        if (id !== false)
            input.attr("id", id);
        if (required !== false)
            input.attr("required", "required");
        if (placeholder !== false)
            input.attr("placeholder", placeholder);
        // INSERT IT
        input.insertBefore($(this));
        if (remove !== false)
            $(this).remove();
    })

});
