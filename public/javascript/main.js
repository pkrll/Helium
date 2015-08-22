(function() {
    /**
     * Checks when the DOM has loaded and runs
     * the supplied callback function. Used as
     * an extension of the document object =>
     * "document.DOMReady(function() { ... })"
     *
     * @param   Function    The function to run
     *                      upon DOM ready.
     */
    Document.prototype.DOMReady = function(fn) {
        var onReadyFired = false;
        var onReady = function() {
            if (onReadyFired === false) {
                onReadyFired = true;
                fn();
            }
        }
        // Browser compatibility
        if (document.addEventListener) {
            document.addEventListener("DOMContentLoaded", onReady, false);
                window.addEventListener("load", onReady, false);
        } else {
            // IE fix
            document.attachEvent("onreadystatechange", fn);
            if (!onReadyFired)
                window.attachEvent("onload", onReady);
        }
    }

    /**
     * Shorthand for calling the Helium library.
     *
     * @param   string  The selector
     * @returns object  A new instance of Helium
     */
    _ = function(selector) {
        return new Helium(selector);
    }

    /**
     * The Helium library constructor.
     *
     * @param   string  The selector
     * @returns object
     */
    var Helium = function(selector) {
        this.elem = [];
        if (typeof selector === 'string') {
            if (selector.charAt(0) === '<') {
                var elementName = selector.substring(1,selector.length-1);
                this.elem = [document.createElement(elementName)];
            } else {
                this.elem = document.querySelectorAll(selector);
            }
        } else if (selector.length) {
            this.elem = selector;
        }

        return this;
    }

    Helium.prototype.on = function(event, fn) {
        for (var i = 0; i < this.elem.length; i++)
            this.elem[i].addEventListener(event, fn.bind(this.elem[i]), false);
        return this;
    }

    Helium.prototype.addChild = function(element) {
        for (var i = 0; i < this.elem.length; i++) {
            if (element instanceof Helium) {
                for (var x = 0; x < element.elem.length; x++)
                    this.elem[i].appendChild(element.elem[i]);
            } else {
                this.elem[i].appendChild(element);
            }
        }

        return this;
    }

    Helium.prototype.addClass = function(className) {
        for (var i = 0; i < this.elem.length; i++)
            this.elem[i].classList.add(className);
        return this;
    }

    Helium.prototype.addAttribute = function(attribute, value) {
        if (typeof attribute === 'string') {
            for (var i = 0; i < this.elem.length; i++)
                this.elem[i].setAttribute(attribute, value);
        } else if (typeof attribute === 'object') {
            for (var i = 0; i < this.elem.length; i++)
                for (var key in attribute)
                    if (attribute.hasOwnProperty(key))
                        this.elem[i].setAttribute(key, attribute[key]);
        }

        return this;
    }

    Helium.prototype.remove = function() {
        for (var i = 0; i < this.elem.length; i++)
            this.elem[i].parentNode.removeChild(this.elem[i]);
    }

    Helium.prototype.find = function(selector) {
        var elements = [];
        for (var i = 0; i < this.elem.length; i++)
            elements.push(this.elem[i].querySelectorAll(selector));
        return new Helium(elements);
    }

})();
