/**
 * Javascript plugin
 * Dropify 1.1
 *
 * Adds drag and drop functionality to an HTML element,
 * and uploading files to the server.
 *
 * @version 1.1
 * @author Ardalan Samimi
 */
(function($) {

    var Dropify = function (element, options) {
        this.element    = $(element);
        // Set the options
        this.settings   = $.extend({
            "url"               : false,
            "consecutiveLimit"  : false,
            "loaderImagePath"   : "/public/images/system/loading-128.png",
            "extensions"        : ["jpg", "jpeg", "gif", "png"],
            "onDownload"        : false,
            "onUpload"          : false,
            "onReady"           : false,
            "onError"           : false,
            "monitor"           : false,
            "totalSizeToLoad"   : 0,
            "totalSizeLoaded"   : 0
        }, options || {});
        // Bind the drag events
        this.bindDragEvents();
    };

    Dropify.prototype = {
        /**
         * Returns a key from the
         * settings collection.
         *
         * @param   string  Name of setting
         * @returns mixed
         */
        getSetting: function (key) {
            return this.settings[key];
        },
        /**
         * Check the extension of the file(s)
         * to be uploaded, comparing to the
         * array of file extensions set in
         * settings.extensions.
         *
         * @param   string  Name of file
         * @returns bool
         */
        checkExtension: function (fileName) {
            extension = fileName.split('.').pop().toLowerCase();
            if ($.inArray(extension, this.settings.extensions) != -1) {
                return true;
            }

            return false;
        },
        /**
         * Creates a dialog window, if the
         * default progress and on ready
         * functions are not overriden.
         *
         * @param   bool    If a spinner should be shown.
         */
        createWindow: function (withLoaderImage) {
            var withLoaderImage = withLoaderImage || false;
            var div = $("<div>");
            // Create the dialog window
            var divWindow   = div.clone().attr({"id": "dropify-window"});
            var divHeader   = div.clone().attr({"class": "dropify-window-header"}).appendTo(divWindow);
            var divBody     = div.clone().attr({"class": "dropify-window-body"}).appendTo(divWindow);
            var divFooter   = div.clone().attr({"class": "dropify-window-footer"}).appendTo(divWindow);
            var divButton   = div.clone().attr({"class": "dropify-window-button"}).html("OK").appendTo(divFooter);
            // Bind the button
            divButton.on("click", function() {
                $("#dropify-window").remove();
            })
            // Adds a spinner image
            if (withLoaderImage) {
                var imgElement  = $("<img>").attr({"src": this.settings.loaderImagePath}).appendTo(divBody);
            }
            // Show the window
            divWindow.appendTo("body");
        },
        /**
         * Default monitoring function for
         * uploading to the server, will
         * be called if not overriden.
         *
         * @param   progressEvent   The progressEvent object from XMLHttpRequest upload.onprogress
         */
        onUpload: function (event) {
            // Calculate the progress
            var completed   = 0;
            if (event.lengthComputable)
                completed = Math.round((event.loaded / event.total * 1000) / 10);
            // Show the progress
            this.onProgress("Uploading files... " + completed + "%");
        },
        /**
         * Default monitoring function for
         * downloading from the server.
         *
         * @param   progressEvent   The progressEvent object from XMLHttpRequest onprogress
         */
        onDownload: function (event) {
            // Calculate the progress
            var completed = (Math.round((++this.settings.totalSizeLoaded / this.settings.totalSizeToLoad * 1000) / 10));
            // Show the progress
            this.onProgress("Uploading files... " + completed + "%");

        },
        onProgress: function (progress) {
            if ($("#dropify-window").length < 1)
                this.createWindow(true);
            // Find the header and show the progress
            $(".dropify-window-header").html(progress);
        },
        /**
         * The default ready function, will
         * be called if not overriden.
         *
         * @param
         * @returns
         */
        onReady: function () {
            if ($("#dropify-window").length < 1)
                this.createWindow(false);
            var divHeader   = $(".dropify-window-header");
            var divBody     = $(".dropify-window-body");
            // Set the new status
            divHeader.html("Upload finish!");
            divBody.children().remove();
            divBody.html("The images have been successfully uploaded.");
        },
        /**
         * Called upon error. Can be ovverriden.
         *
         * @param   string  The error message
         */
        onError: function (message) {
            if ($("#dropify-window").length < 1)
                this.createWindow(false);
            var divHeader   = $(".dropify-window-header");
            var divBody     = $(".dropify-window-body");
            // Set the new status
            divHeader.html("Upload error");
            divBody.children().remove();
            divBody.html("An error has occurred: " + message);
        },
        /**
         * Binds the elements and DOM drag events.
         * Called upon initialization.
         *
         */
        bindDragEvents: function() {
            var self = this;
            var _elem = this.element;;
            // Bind the elements drag events
            _elem.on("dragenter", function (event) { self.dragEnter(event, _elem); });
            _elem.on("dragover", function (event) { self.dragOver(event); });
            _elem.on("drop", function (event) { self.drop(event, _elem); });
            _elem.on("dragleave", function (event) { self.dragLeave (event); });
            // Bind the drag events to the DOM.
            // This will make sure the highlights
            // dissapear on the valid drop targets
            // when the dragging exists those areas.
            $(document).on("dragenter", function (event) { self.dragEnter(event); });
            $(document).on("drop", function (event) { self.drop(event); });
            $(document).on("dragover", function (event) { self.dragOver(event, _elem); });
        },
        /**
         * This function will fire when a
         * dragged object enters the valid
         * drop zone. The drop target will
         * get highlighted through css.
         *
         * @param eventObject
         * @param Element
         */
        dragEnter: function (event, elem) {
            $('.dropify-highlight').removeClass('dropify-highlight');
            var elem = elem || false;
            if (elem !== false)
                elem.addClass("dropify-highlight");
            this.onDrop(event);
        },
        /**
         * This function will fire when an
         * object is being dragged over the
         * valid drop zone. If an element is
         * provided, it will be stripped of
         * the class highlight. This is for
         * when the drag leaves the valid drop
         * target and enters the document body.
         *
         * @param eventObject
         * @param Element
         */
         dragOver: function (event, elem) {
             var elem = elem || false;
             if (elem !== false)
                elem.removeClass("dropify-highlight");
            this.onDrop(event);
         },
        /**
         * This function will fire when an
         * object is being dragged over the
         * valid drop zone. If an element is
         * provided, it will be stripped of
         * the class highlight. This is for
         * when the drag leaves the valid drop
         * target and enters the document body.
         *
         * @param eventObject
         * @param Element
         */
         dragLeave: function (event, elem) {
             var elem = elem || false;
             if (elem !== false)
                elem.removeClass("dropify-highlight");
            this.dragOver(event);
        },
        /**
         * This function will fire when a
         * dragged object is dropped on a
         * valid target zone. It will call
         * the function dragAndDrop with
         * the drop targets type (cover or
         * slideshow) as one of the params.
         *
         * @param eventObject
         * @param Element
         */
         drop: function (event, elem) {
             var elem   = elem || false;
             var upload = false;
             if (elem !== false) {
                 elem.removeClass("dropify-highlight");
                 upload = true;
             }
             this.onDrop(event, upload);
        },
        /**
         * Determines if the drag/drop was valid
         * and creates a formData object to send
         * to the method Send().
         *
         * @param eventTarget   To stop default actions
         * @param bool          Is Upload?
         */
         onDrop: function (event, upload) {
             var upload = upload || false;
             event.stopPropagation();
             event.preventDefault();
             // Check if an object was dropped on the
             // designated target area or not.
             if (upload === true) {
                 // Sort through the files that were
                 // dropped and add it to the formdata.
                 var files  = event.originalEvent.dataTransfer.files;
                 var fData  = new FormData();
                 var error  = false;
                 var self   = this;
                 $.each(files, function(x, file) {
                     // If the user has tried uploading files with
                     //  anything other than the allowed extensions
                     // then abort the whole operation.
                     if (self.checkExtension(file.name) === false) {
                         var onError = self.getSetting("onError");
                         if (onError === false) {
                            self.onError("Could not upload file " + file.name + ". File extension not allowed.");
                        } else {
                            onError("Could not upload file " + file.name + ". File extension not allowed.");
                        }
                         error = true;
                         return false;
                     } else {
                         // Append files to formdata
                         fData.append('file'+x, file);
                     }
                     // Stop if the limit has been reached
                     if (self.settings.consecutiveLimit == (x+1))
                         return false;
                 });
                 if (error)
                    return false;
                 // Send the dropped files
                 this.sendDrop(fData, files.length);
             }
         },
         /**
          * Send the files to the server.
          *
          * @param  formData    The data to be sent
          * @param       int    Size of the package
          */
         sendDrop: function (dataPackage, packageSize) {
             // The data package and size is crucial
             var dataPackage = dataPackage || false,
                 packageSize = packageSize || false;
             if (dataPackage === false || packageSize === false)
                return false;
            // Declare self as the object, for scope
            // issues. Also, declare the XMLHttpRequest.
            var self = this;
            var xhr = new XMLHttpRequest();
            // Set the upload monitoring, either the
            // default or user overriden function.
            xhr.upload.onprogress = function (event) {
                if (self.settings.onUpload === false) {
                    self.onUpload(event);
                } else {
                    self.settings.onUpload(event);
                }
            }
            // Set the download monitoring, either the
            // default or user overriden function.
            self.settings.totalSizeToLoad = packageSize;
            xhr.onprogress = function (event) {
                if (self.settings.onDownload === false) {
                    self.onDownload(event);
                } else {
                    self.settings.onDownload(event);
                }
            }
            // When the image upload is done, run either
            // the user defined or the default function.
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (self.settings.onReady === false) {
                        self.onReady();
                    } else {
                        self.settings.onReady(xhr.responseText);
                    }

                }
            }
            // Make the request, only if an URL is set.
            if (self.settings.url !== false) {
                xhr.open('POST', self.settings.url);
        		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        		xhr.send(dataPackage);
            } else {
                if (self.settings.onError === false) {
                    self.onError("No upload path set.");
                } else {
                    self.settings.onError("No upload path set.");
                }
            }
         }
    };

    $.fn.dropify = function(options) {
        return new Dropify(this, options);
    };

})(jQuery);