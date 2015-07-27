$(document).ready(function() {

    /**
     * Update articles categories.
     *
     * @param   HTML element
     */
    $.fn.updateCategory = function (element) {
        var element = element || false;
        if (element === false)
            return false;
        // Get both the old and new value, and
        // compare them before proceeding.
        var oldValue = element.attr("data-value");
        var newValue = element.val();
        if (oldValue != newValue) {
            // Create a form data object with
            // the id and new category name.
            var formData    = new FormData();
            var categoryID  = element.attr("data-id");
            formData.append("id", categoryID);
            formData.append("name", newValue);
            // Create an instance of XMLHttpRequest,
            // and set the readystate trigger.
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    var response = jQuery.parseJSON(xhr.responseText);
                    if (response.error)
                        $.fn.createErrorMessage(resresponse.error.message);
                    // Reset the global variable
                    window.autosaveInProgress = false;
                }
            }
            // Make the request
            xhr.open("POST", "/articles/categories/update", true);
            xhr.send(formData);
        }
    }

    /**
     * Called when events focusout or keyup
     * is triggered by the input element.
     *
     * @param   string  Name of event
     * @param   element The trigger element
     * @param   string  event.keyCode
     */
    $.fn.onInputChange = function (eventType, element, keyCode) {
        if (eventType === "focusout") {
            if (window.autosaveInProgress !== true)
                $.fn.updateCategory(element);
        } else if (eventType === "keyup") {
            if (keyCode == 13) {
                // Set a global variable to prevent the
                // update function to run twice when the
                // input element loses focus.
                window.autosaveInProgress = true;
                $.fn.updateCategory(element);
                // Remove the focus
                element.blur();
            }
        }
    }

    /**
     * Called when the delete
     * button is used
     *
     * @param   element The trigger element
     */
    $.fn.onButtonClick = function (element) {
        var element = element || false;
        if (element === false)
            return false;
        // Get the category id, and grey out the
        // area so the user cannot make any changes
        // during the removal.
        var categoryId = element.attr("data-id");
        var parentElem = element.parent().parent();
        parentElem.addClass("greyed-out");
        parentElem.find("input").attr("readonly", true);
        element.removeClass("remove-category");
        // Create the form data and make the AJAX-
        // request to remove it.
        var formData = new FormData();
        formData.append("id", categoryId);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                var response = jQuery.parseJSON(xhr.responseText);
                if (response.error) {
                    // Upon error, display the error message,
                    // and reenable the elements again.
                    $.fn.createErrorMessage(response.error.message);
                    parentElem.removeClass("greyed-out");
                    parentElem.find("input").attr("readonly", false);
                    element.addClass("remove-category");
                } else {
                    parentElem.fadeOut(250, function() {
                        $(this).remove();
                    });
                }
            }
        }
        // Make the request
        xhr.open("POST", "/articles/categories/remove", true);
        xhr.send(formData);
    }

    /**
     * Listen for when the text
     * input element loses focus.
     *
     * @param   eventObject
     */
    $(".autosave-input").on("focusout", function (event) {
        $.fn.onInputChange("focusout", $(this), 0);
    });

    /**
     * Listen for when the enter key is
     * used inside the text input element.
     *
     * @param   eventObject
     */
    $(".autosave-input").on("keyup", function (event) {
        $.fn.onInputChange("keyup", $(this), event.keyCode);
    });

    /**
     * Listen for when the delete
     * button is used.
     *
     */
    $(".remove-category").on("click", function () {
        $.fn.onButtonClick($(this));
    });

    /**
     * Adds a category
     *
     * @param   eventObject
     */
    $(".add-input").on("keydown", function (event) {
        if (event.keyCode == 13) {
            var self = $(this);
            var name = self.val();
            if (name.length > 0) {
                var formData = new FormData();
                formData.append("name", name);
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        var response = jQuery.parseJSON(xhr.responseText);
                        if (response.error) {
                            $.fn.createErrorMessage(response.error.message);
                        } else {
                            // Reset the input and create a new row
                            self.val("");
                            var div = $("<div>");
                            var divRow      = div.clone().attr({"class": "stylized-form-row unboxed"});
                            var divLabel    = div.clone().attr({"class": "label"}).appendTo(divRow);
                            var input       = $("<input>").attr({
                                "type": "text",
                                "class": "autosave-input",
                                "value": name,
                                "data-id": response,
                                "data-value": name,
                            }).appendTo(divLabel);
                            var divInput    = div.clone().attr({"class": "input"}).appendTo(divRow);
                            var spanButton  = $("<span>").attr({
                                "class": "font-icon icon-cancel remove-category",
                                "data-id": response
                            }).appendTo(divInput);
                            divRow.hide().appendTo(".stylized-form").fadeIn(250);
                            // Bind the shite
                            spanButton.on("click", function () { $.fn.onButtonClick($(this)); });
                            input.on("keyup", function (event) { $.fn.onInputChange("keyup", $(this), event.keyCode); });
                            input.on("keyup", function (event) { $.fn.onInputChange("keyup", $(this), event.keyCode); });
                        }
                    }
                }
                xhr.open("POST", "/articles/categories/add", true);
                xhr.send(formData);
            }
        }
    });

});
