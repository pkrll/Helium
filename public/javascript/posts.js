$(document).ready(function() {

    $(".dismiss").on("click", function() {
        $(this).parent().parent().remove();
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
        var parent = $(this).attr("data-parent") || false;
        var inpClass = $(this).attr("data-class") || false;
        var required = $(this).attr("data-required") || false;
        var placeholder = $(this).attr("data-placeholder") || false;
        if (type === false)
            return false;
        // Create the label, if requested,
        // that will sit above the new input.
        if (parent === false)
            parent = $(this).parent();
        // Create the input with the values
        // provided by the triggering element.
        var input = $("<input>").attr({
            "type": type,
            "autocomplete": "off"
        });
        // The optional values
        if (id !== false)
            input.attr("id", id);
        if (name !== false)
            input.attr("name", name);
        if (inpClass !== false)
            input.attr("class", inpClass);
        if (required !== false)
            input.attr("required", "required");
        if (placeholder !== false)
            input.attr("placeholder", placeholder);
        // If the input is a internal links box
        // then put it inside a div container.
        if (inpClass === "links") {
            input.appendTo(parent);
            // Bind the input so it
            // can do the searching.
            input.on("keyup", function(event) {
                $.fn.inputSearchEvent(event, $(this));
            }).on("search", function() {
                $.fn.inputSearchEvent("search", $(this));
            });
        } else {
            input.insertBefore($(this));
        }

        if (remove !== false)
            $(this).remove();
    });

    /**
     * Binds the keyup event of the search
     * input fields to the inputSearchEvent
     * function.
     *
     * @param       object  event
     */
    $("input.links").on("keyup", function(event) {
        $.fn.inputSearchEvent(event, $(this));
    });

    /**
     * Remove the suggestion box and the
     * hidden input field if any.
     */
    $("input.links").on("search", function(event) {
        $.fn.inputSearchEvent("search", $(this));
    });

    $.fn.removeLinkedArticle = function (self) {
        // Remove the suggestions box but also
        // the hidden input field representing
        // the linked item.
        $("div.suggestions").remove();
        var id = self.attr("data-id");
        var parentElement = $("form");
        var hiddenInput = parentElement.find("input[type='hidden'][value="+id+"]");
        if (hiddenInput.length > 0) {
            if (self.attr("data-edit") === "true") {
                var removedLink = $("<input>").attr({
                    "type": "hidden",
                    "value": id,
                    "name": "link-remove[]"
                }).appendTo(parentElement);
            }
            hiddenInput.remove();
        }
    }

    /**
     * This function merges the keyup and
     * the search events. If event is set
     * to search, that means the user has
     * cleared the input. This will remove
     * the suggestion box and also remove
     * the hidden input field if there are
     * any. Otherwise, search for internal
     * links to add, fires 0.5 seconds after
     * the last key input by user.
     *
     * @param       mixed   event
     * @param       element self
     */
    var searchTimeout;
    $.fn.inputSearchEvent = function (event, self) {
        // The search event fires either on enter
        // key or when the cancel button is pressed
        // If the search box is empty, that probably
        // means the latter.
        if (event === "search") {
            if (self.val().length === 0) {
                $.fn.removeLinkedArticle(self);
            }
        } else {
            var keyCode = event.keyCode;
            // Keys like arrows up, left, right and
            // enter and others should not be counted.
            if (keyCode !== 91 && keyCode !== 38 &&
                keyCode !== 37 && keyCode !== 39 &&
                keyCode !== 20 && keyCode !== 16 &&
                keyCode !== 17 && keyCode !== 18 &&
                keyCode !== 13 && keyCode !== 93) {
                var suggestionsDiv = $("div.suggestions");
                if (keyCode === 40) {
                    if (suggestionsDiv.length)
                        $.fn.moveDown($(this));
                        return false;
                }
                // Clear the search timeout and add
                // a new one half a second long before
                // actually doing the search.
                window.clearTimeout(searchTimeout);
                 searchTimeout = window.setTimeout(function() {
                     // Remove the previous suggestion
                     //box, if there were any.
                     if (suggestionsDiv.length > 0)
                         suggestionsDiv.remove();
                     var searchString = self.val();
                     if (searchString.length > 0)
                        self.parent().addClass("searching");
                    else
                        $.fn.removeLinkedArticle(self);
                    $.fn.searchForArticle (self, searchString);
                 }, 500);
            } else if (keyCode === 38) {
                if ($("div.suggestions").length)
                    $.fn.moveUp($(this));
            } else if (keyCode === 13) {
                if ($("div.suggestions").length)
                    $.fn.selectFocusedDiv($(this));
            }
        }
    }

    /**
     * AJAX call to server that retrieves
     * ten search results based on query
     * searchString.
     *
     * @param       element element
     * @param       string  searchString
     */
    $.fn.searchForArticle = function (element, searchString) {
        var searchString = searchString || false,
                 element = element || false;
        if (searchString === false || element === false)
            return null;
        var data = new FormData();
        data.append("searchString", searchString);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/content/search/posts/'+$("form").attr("data-id"));
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.onload = function() {
			// If the request succeeded
			if (xhr.status === 200) {
                var response = jQuery.parseJSON(xhr.responseText);
                if (response.error) {
                    $.fn.createErrorMessage(response.error.message);
                } else {
                    $.fn.createSuggestionsBox(element, response);
                }
			}
		}
		xhr.send(data);
    }

    /**
     * Creates the suggestions box.
     *
     * @param       element element
     * @param       array   suggestions
     */
    $.fn.createSuggestionsBox = function (element, suggestions) {
        var suggestions = suggestions || false;
        if (suggestions === false)
            return null;
        element.parent().removeClass("searching");
        // After variable check, get or create
        // the div that is the suggestions box.
        var suggestionsDiv = $("div.suggestions");
        if (suggestionsDiv.length === 0) {
            suggestionsDiv = $("<div>").attr({
                "class": "suggestions"
            }).insertAfter(element);
        }
        // Loop through the suggestions and
        // display below the element.
        if (suggestions.length > 0) {
            $.each(suggestions, function(index, item) {
                var suggestionDiv = $("<div>").attr({
                    "class": "suggestion",
                    "tabindex": -1
                }).append(item.headline + " (id:"+item.id+")").appendTo(suggestionsDiv);
                // When clicked, the result should
                // be added to the input, but also
                // create a hidden input field.
                var parentElement = $("form");
                suggestionDiv.on("click", function() {
                    element.addClass("no-padding");
                    element.val($(this).html());
                    element.attr("data-id", item.id);
                    var hiddenInput = $("<input>").attr({
                        "type": "hidden",
                        "name": "links[]",
                        "value": item.id,
                    }).appendTo(parentElement);
                    $(this).parent().remove();
                });
            });
        }
    }

    /**
     * Move selection of suggestions
     * box down an item.
     *
     * @param   element element
     */
    $.fn.moveDown = function (element) {
        if ($(".suggestions").length) {
            if ($(".suggestion.focused").length) {
                var selected = $(".suggestion.focused");
                if (selected.next().length) {
                    selected.next().addClass("focused").siblings().removeClass("focused");
                } else {
                    selected.removeClass("focused");
                    $(".suggestions div:first-child").addClass("focused");
                }
            } else {
                $(".suggestions div:first-child").addClass("focused");
            }
        }
    }

    /**
     * Move selection of suggestions
     * box up an item.
     *
     * @param   element element
     */
    $.fn.moveUp = function (element) {
        if ($(".suggestions").length) {
            if ($(".suggestion.focused").length) {
                var selected = $(".suggestion.focused");
                if (selected.prev().length) {
                    selected.prev().addClass("focused").siblings().removeClass("focused");
                } else {
                    selected.removeClass("focused");
                    $(".suggestions div:last-child").addClass("focused");
                }
            } else {
                $(".suggestions div:last-child").addClass("focused");
            }
        }
    }

    /**
     * Select the current selection
     * and emulate a single click.
     *
     * @param   element element
     */
    $.fn.selectFocusedDiv = function (element) {
        var selected = $(".suggestions").find("div.focused");
        if (selected.length)
            selected.trigger("click");
        return false;
    }
});
