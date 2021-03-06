window.addEventListener('load', function() {
    var editor;

    ContentTools.IMAGE_UPLOADER = imageUploader;

    ContentTools.StylePalette.add([
        new ContentTools.Style('Autor', 'autor', ['p']),
        new ContentTools.Style('nota', 'nota', ['p']),
        new ContentTools.Style('Titulo', 'titulo', ['h1'])
    ]);

    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');

    editor.addEventListener('saved', function (ev) {
        var name, onStateChange, passive, payload, regions, xhr;

        // Check if this was a passive save
        passive = ev.detail().passive;

        // Check to see if there are any changes to save
        regions = ev.detail().regions;
        if (Object.keys(regions).length == 0) {
            return;
        }

        // Set the editors state to busy while we save our changes
        this.busy(true);

        // Collect the contents of each region into a FormData instance
        payload = new FormData();
        payload.append('__page__', window.location.pathname);
        for (name in regions) {
            payload.append(name, regions[name]);
        }
        payload.append('blogID', document.getElementById('blogID').value);

        // Send the update content to the server to be saved
        onStateChange = function(ev) {
            // Check if the request is finished
            if (ev.target.readyState == 4) {
                editor.busy(false);
                if (ev.target.status == '200') {
                    console.log(document.getElementById('blogID'));
                    document.getElementById('blogID').value = ev.target.responseText;
                    // Save was successful, notify the user with a flash
                    if (!passive) {
                        new ContentTools.FlashUI('ok');
                    }
                } else {
                    // Save failed, notify the user with a flash
                    new ContentTools.FlashUI('no');
                }
            }
        };

        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', onStateChange);
        xhr.open('POST', '/editarBlog');
        xhr.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
        xhr.send(payload);
    });

    // Add support for auto-save
    editor.addEventListener('start', function (ev) {
        var _this = this;

        // Call save every 30 seconds
        function autoSave() {
            _this.save(true);
        };
        this.autoSaveTimer = setInterval(autoSave, 30 * 1000);
    });

    editor.addEventListener('stop', function (ev) {
        // Stop the autosave
        clearInterval(this.autoSaveTimer);
    });



    function imageUploader(dialog) {
        var image, xhr, xhrComplete, xhrProgress;

        // Set up the event handlers
        dialog.addEventListener('imageuploader.cancelupload', function () {
            // Cancel the current upload

            // Stop the upload
            if (xhr) {
                xhr.upload.removeEventListener('progress', xhrProgress);
                xhr.removeEventListener('readystatechange', xhrComplete);
                xhr.abort();
            }

            // Set the dialog to empty
            dialog.state('empty');
        });

        dialog.addEventListener('imageuploader.clear', function () {
            // Clear the current image
            dialog.clear();
            image = null;
        });

        dialog.addEventListener('imageuploader.fileready', function (ev) {

            // Upload a file to the server
            var formData;
            var file = ev.detail().file;

            // Define functions to handle upload progress and completion
            xhrProgress = function (ev) {
                // Set the progress for the upload
                dialog.progress((ev.loaded / ev.total) * 100);
            }

            xhrComplete = function (ev) {
                var response;

                // Check the request is complete
                if (ev.target.readyState != 4) {
                    return;
                }

                // Clear the request
                xhr = null
                xhrProgress = null
                xhrComplete = null

                // Handle the result of the upload
                if (parseInt(ev.target.status) == 200) {
                    // Unpack the response (from JSON)
                    response = JSON.parse(ev.target.responseText);

                    // Store the image details
                    image = {
                        size: response.size,
                        url: response.url
                    };

                    // Populate the dialog
                    dialog.populate(image.url, image.size);

                } else {
                    // The request failed, notify the user
                    new ContentTools.FlashUI('no');
                }
            }

            // Set the dialog state to uploading and reset the progress bar to 0
            dialog.state('uploading');
            dialog.progress(0);

            // Build the form data to post to the server
            formData = new FormData();
            formData.append('image', file);

            // Make the request
            xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', xhrProgress);
            xhr.addEventListener('readystatechange', xhrComplete);
            xhr.open('POST', '/upload-image', true);
            xhr.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
            xhr.send(formData);
        });

        dialog.addEventListener('imageuploader.save', function () {
            var crop, cropRegion, formData;

            // Define a function to handle the request completion
            xhrComplete = function (ev) {
                // Check the request is complete
                if (ev.target.readyState !== 4) {
                    return;
                }

                // Clear the request
                xhr = null
                xhrComplete = null

                // Free the dialog from its busy state
                dialog.busy(false);

                // Handle the result of the rotation
                if (parseInt(ev.target.status) === 200) {
                    // Unpack the response (from JSON)
                    var response = JSON.parse(ev.target.responseText);

                    // Trigger the save event against the dialog with details of the
                    // image to be inserted.
                    dialog.save(
                        response.url,
                        response.size,
                        {
                            'alt': response.alt,
                            'data-ce-max-width': response.size[0]
                        });

                } else {
                    // The request failed, notify the user
                    new ContentTools.FlashUI('no');
                }
            }

            // Set the dialog to busy while the rotate is performed
            dialog.busy(true);

            // Build the form data to post to the server
            formData = new FormData();
            formData.append('url', image.url);

            // Set the width of the image when it's inserted, this is a default
            // the user will be able to resize the image afterwards.
            formData.append('width', 600);

            // Check if a crop region has been defined by the user
            if (dialog.cropRegion()) {
                formData.append('crop', dialog.cropRegion());
            }

            // Make the request
            xhr = new XMLHttpRequest();
            xhr.addEventListener('readystatechange', xhrComplete);
            xhr.open('POST', '/insert-image', true);
            xhr.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
            xhr.send(formData);
        });
    }
});