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
            var self = this;
            $.getJSON('/public/javascript/lang/lang.'+lang+'.json').success(function (data) {
                self.localizedStrings = data;
            });
        }
    }

})(jQuery);
