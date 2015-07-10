/*
 * Javascript plugin
 * Tooltip
 *
 * Add small tooltips below, above
 * or next to HTML elements.
 *
 * @version 1.0
 * @author Ardalan Samimi
 */
(function ($) {

    Tooltip = function (settings, reset) {
        // Check if object was called
        // with the 'new' keyword.
        if (this instanceof Tooltip) {
            // Set reset option
            var reset = reset || false;
            this.reset = reset;
            // Set the settings
            this.settings = $.extend({
                "label": "",
                "arrow": "top",
                "fadeOut": null,
                "element": null
            }, settings || {});

            this.setTooltip();
        } else {
            return new Tooltip (settings, reset);
        }
    }

    Tooltip.prototype = {
        // Create the tooltip
        setTooltip: function () {
            // Remove the other tooltips
            // if it was requested.
            if (this.reset !== false)
                this.resetTooltip();
            // Create the tooltip elements
            var container = $("<div>").attr({
                "class": "error-label-container"
            }).appendTo(this.settings.element);
            var arrow = $("<div>").attr({
                "class": "error-label-arrow-" + this.settings.arrow
            }).appendTo(container);
            var label = $("<div>").attr({
                "class": "error-label"
            }).html(this.settings.label).appendTo(container);
            // Set the red glow around the input
            this.settings.element.addClass("tooltip-active");
            // Set it to fadeout
            if ($.isNumeric(this.settings.fadeOut))
                container.fadeOut(this.settings.fadeOut);
            else
                label.click(function () {
                    $(this).parent().remove();
                });
        },
        resetTooltip: function () {
            $(".error-label-container").remove();
            $(".tooltip-container").removeClass("tooltip-active");
        }
    }

})(jQuery);
