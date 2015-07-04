$(document).ready(function() {

    $.fn.createInputElement = function (attributes) {
        var attributes = attributes || null;
        var input = $("<input>").attr(attributes);
        return input;
    }

    $.fn.createButtonElement = function (label, attributes, onClick) {
        var label = label || null;
        var attributes = attributes || null;
        var onClick = onClick || false;
        var button = $("<button>").attr(attributes).html(label);
        button.click(onClick);
        return button;
    }

});
