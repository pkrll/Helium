/*
 * jQuery plugin
 * Browser detection
 *
 * @version 1.0
 * @author Ardalan Samimi
 */
(function ($) {

    jQuery.fn.Browser = function () { }

    jQuery.fn.Browser.safari = function () {
        var userAgent = navigator.userAgent.toLowerCase();
        return /safari/.test(userAgent) && !/chrome/.test(userAgent);
    }

    jQuery.fn.Browser.firefox = function () {
        var userAgent = navigator.userAgent.toLowerCase();
        return /firefox/.test(userAgent);
    }

    jQuery.fn.Browser.chrome = function () {
        var userAgent = navigator.userAgent.toLowerCase();
        return /chrome/.test(userAgent);
    }

    jQuery.fn.Browser.msie = function () {
        var userAgent = navigator.userAgent.toLowerCase();
        return /msie/.test(userAgent);
    }

    jQuery.fn.Browser.opera = function () {
        var userAgent = navigator.userAgent.toLowerCase();
        return /opera/.test(userAgent);
    }

})(jQuery);
