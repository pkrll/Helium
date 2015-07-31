            <div id="upload" style="">

                <div class="dragzone" id="dragzone-ckeditor">
                    <div class="label">
                        <p><?=ADMIN_GALLERY_DRAGANDDROP?></p>
                        <p><?=ADMIN_GALLERY_ALLOWEDEXTS?></p>
                    </div>
                    <div class="input">
                        <input type="file" name="image-ckeditor" id="image-ckeditor" />
                    </div>
                </div>

            </div>

            <div id="preview"></div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $("#dragzone-ckeditor").dropster({
                        url: '/upload/image/ckeditor/stream',
                        onUpload: $.fn.onUpload,
                        onDownload: $.fn.onDownloadCKEditor,
                        onReady: $.fn.onReady
                    });
                });
            </script>
