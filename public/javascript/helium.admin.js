$(document).ready(function() {

    $("#menu-bar-header").click(function () {
        var href = $(this).find("a").attr("href");
        window.location.href = href;
    });

    $(".menu-bar-li").click(function () {
        var href = $(this).attr("data-href") || false;
        if (href !== false && href === "open:sub-menu") {
            var children = $(this).nextUntil(".menu-bar-li:not(.sub-menu)");
            children.slideToggle();
            $(this).toggleClass('menu-active');
        } else if (href !== false) {
            window.location.href = href;
        }

    });

});
