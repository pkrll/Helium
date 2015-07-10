/**
 * Javascript plugin
 * Localize
 *
 * Localization for JS Strings.
 *
 * @version 1.0
 * @author Ardalan Samimi
 */
(function($) {

    Localize = function(settings) {
        this.settings = jQuery.extend({
            "lang": "en"
        }, settings || false);

        this.setLocaleString(this.settings.lang);
    };

    Localize.prototype = {
        getLocaleString: function (params) {
            var string = this.localizedStrings[params];
            if (string)
                return string;
            else
                return params;
        },

        setLocaleString: function (lang) {
            var file = '/public/javascript/lang/lang.'+lang+'.json';
            var self = this;
            $.getJSON(file, function(data) {
                self.localizedStrings = data;
            }).fail(function () {
                self.localizedStrings = "";
            });
        }
    }

})(jQuery);
