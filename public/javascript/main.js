$(document).ready(function() {

    $("#splash").css({'opacity':0}).animate({'opacity':1},750);


    $("ul#list-menu > li").click(function() {
        $(this).parent().animate({
            'top': $(window).height()
            }, 500,
            function() {
                $(this).hide();
            }
        );

    });

});
