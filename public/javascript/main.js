$(document).ready(function() {

    $("#user-center .header-button").on("click", function() {
        $(this).parent().find(".user-menu").toggleClass("active");
    });

    $(".user-menu-item").on("click", function() {
        var link = $(this).attr("data-href");
        if (link !== undefined)
            window.location.href = link;
    });

});
