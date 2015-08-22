document.DOMReady(function() {

    _(".add-link").on("click", function() {
        var input = _("<input>").addAttribute({
            "type": "search",
            "placeholder": "Search for article..."
        }).addClass("links");
        _(".links-container").addChild(input);
    });

});
