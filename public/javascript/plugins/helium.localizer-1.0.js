/**
 * Javascript plugin
 * Localizer
 *
 * Localization for JS Strings.
 *
 * @version 1.0
 * @author Ardalan Samimi
 */
(function($) {

    Localizer = function(settings) {
        if (this instanceof Localizer) {
            this.settings = $.extend({
                "lang": "en"
            }, settings || {});

            this.setLocaleString(this.settings.lang);
        } else {
            return new Localizer (settings);
        }
    }

    Localizer.prototype = {
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
