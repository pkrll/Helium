                    <div class="split-view">
                        <div class="left-view">
                            <div class="quick-menu">
                                <a href="/articles/archive"><div class="quick-menu-button">Archive</div></a>
                                <a href="/articles/create"><div class="quick-menu-button active">Add post</div></a>
                            </div>

                            <div class="stylized-form">

                                <div class="stylized-form-header">
                                    Add post
                                </div>

                                <form id="article" action="/articles/create" method="POST">
                                    <div class="stylized-form-row">
                                        <div class="label">
                                            headline
                                        </div>
                                        <div class="input tooltip-container">
                                            <input type="text" name="headline" id="headline" required="required" autocomplete="off" value="<?=$contents["article"]["headline"]?>"/>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            preamble
                                        </div>
                                        <div class="input tooltip-container">
                                            <textarea name="preamble" id="preamble" required="required"><?=$contents["article"]["preamble"]?></textarea>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            body
                                        </div>
                                        <div class="input tooltip-container">
                                            <textarea name="body" id="body" required="required"><?=$contents["article"]["body"]?></textarea>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row dragzone" id="dragzone-image">
                                        <div class="label">
                                            images
                                        </div>
                                        <div class="input">
                                            <div>
                                                Drag and drop images here, or add by using the button below. The image must be below 2 MB.
                                            </div>
                                            <div>
                                                <input type="file" id="image" />
                                                <button class="image-event-button" data-type="image" data-action="upload">Upload</button>
                                            </div>

                                            <?php
                                                if (!empty($contents["images"]["normal"]["image"])) {
                                            ?>
                                            <div class="image-container">
                                                <?php
                                                    foreach ($contents["images"]["normal"]["image"] AS $key => $image) {
                                                ?>
                                                <div class="picture">
                                                    <div class="picture-box">
                                                        <img src="/public/images/uploads/thumbnails/<?=$image['image_name']?>" />
                                                    </div>

                                                    <div class="caption">
                                                        <div>
                                                            <span class="image-event-button" data-type="image" data-action="remove" data-id="<?=$image['id']?>">
                                                                <span class="font-icon icon-cancel"></span> Remove image
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <input type="text" name="caption-image[]" placeholder="Caption" value="<?=$contents['images']['normal']['caption'][$key]?>">
                                                            <input type="hidden" name="image[]" value="<?=$image['id']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row dragzone" id="dragzone-cover">
                                        <div class="label">
                                            cover image
                                        </div>
                                        <?php
                                            if (!empty($contents['images']['cover']) && $contents['images']['cover']['image'] !== NULL) {
                                        ?>
                                        <div class="input cover">
                                            <div>
                                                <img src="/public/images/uploads/cover/<?=$contents['images']['cover']['image']['image_name']?>" />
                                                <input type="text" name="caption-cover" placeholder="Add a caption" value="<?=$contents['images']['cover']['caption']?>" />
                                                <span class="image-event-button" data-type="cover" data-action="remove" data-id="<?=$contents['images']['cover']['image']['id']?>">
                                                    <span class="font-icon icon-cancel"></span> Remove
                                                </span>
                                                <input type="hidden" name="image-cover" value="<?=$contents['images']['cover']['image']['id']?>" />
                                            </div>
                                        </div>
                                        <?php
                                            } else {
                                        ?>
                                        <div class="input">
                                            <div>
                                                Drag and drop a cover image here, or add by using the button below. The image must be below 2 MB.
                                            </div>
                                            <div>
                                                <input type="file" id="image-cover"/>
                                                <button class="image-event-button" data-type="cover" data-action="upload">Upload</button>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            fact
                                        </div>
                                        <div class="input">
                                            <textarea name="fact" id="fact"><?=$contents["article"]["fact"]?></textarea>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            category
                                        </div>
                                        <div class="input tooltip-container select">
                                            <label class="select tooltip-container">
                                                <select name="category" id="category" required="required">
                                                    <option value="">Choose category</option>
                                                    <?php
                                                        foreach ($constants["categories"] as $key => $value) {
                                                            $selected = ($contents["article"]["category"] === $value["id"]) ? " selected" : "";
                                                    ?>
                                                    <option value="<?=$value['id']?>"<?=$selected?>><?=$value['name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            theme
                                        </div>
                                        <div class="input">
                                            <label class="select">
                                                <select name="theme" id="theme">
                                                    <option value="">Choose theme (optional)</option>
                                                    <option value="1">Theme 1</option>
                                                    <option value="2">Theme 2</option>
                                                    <option value="3">Theme 3</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            tags
                                        </div>
                                        <div class="input">
                                            <input type="text" name="tags" id="tags" placeholder="HTML5, PHP programming, fun ..." value="<?=$contents["article"]["tags"]?>"/>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            links
                                        </div>
                                        <div class="input">
                                            <?php
                                                if (!empty($contents['links'])) {
                                                    foreach ($contents['links'] AS $link) {
                                            ?>
                                                <div class="links-container">
                                                    <input type="search" class="links" placeholder="Search for article..." autocomplete="off" value="<?=$link["headline"]?> (id:<?=$link["id"]?>)"/>
                                                    <input type="hidden" name="links[]" value="<?=$link["id"]?>"/>
                                                </div>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <div class="links-container">
                                                <input type="search" class="links" placeholder="Search for article..." autocomplete="off" />
                                            </div>
                                            <div class="add-input" data-type="search" data-class="links" data-placeholder="Search for article...">
                                                <span class="font-icon icon-plus"></span> Add link
                                            </div>

                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            publish on
                                        </div>
                                        <div class="input publish">
                                            <input type="date" name="published-date" class="published-date" id="published" placeholder="m/d/yyyy" value="<?=$contents["article"]["published-date"]?>"/>
                                            <input type="time" name="published-time" class="published-time" placeholder="00:00" value="<?=$contents["article"]["published-time"]?>"/>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row">
                                        <div class="label">
                                            author
                                        </div>
                                        <div class="input">
                                            <label class="select">
                                                <select name="author" id="author">
                                                    <option value="">Choose author</option>
                                                <?php
                                                    foreach ($constants["authors"]["list"] as $key => $value) {
                                                        $selected = ($constants["authors"]["current"] === $value['id']) ? " selected=\"true\"" : $selected = "";
                                                ?>
                                                    <option value="<?=$value['id']?>"<?=$selected?>><?=$value['author']?></option>
                                                <?php
                                                    }
                                                ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="stylized-form-row last-row">

                                        <div class="input">
                                            <span class="submit-error"></span>
                                            <input type="submit" value="Publish" class="button" />
                                            <input type="button" value="Preview" class="button" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            // Add the different plugins
                            CKEDITOR.replace( 'body', {
                                toolbar: [
                                    ['Bold', 'Italic', 'Underline'],
                                    ['Paste', 'PasteText', 'PasteFromWord'],
                                    ['RemoveFormat'],
                                    ['Link', 'Unlink', 'Image'],
                                    ['Format','Source'],
                                ],
                                width:"100%",
                                height:"400px",
                            } );

                            CKEDITOR.replace( 'preamble', {
                                toolbar: [
                                    ['Bold', 'Italic', 'Underline'],
                                    ['Paste', 'PasteText', 'PasteFromWord'],
                                    ['RemoveFormat'],
                                    ['Format','Source'],
                                ],
                                width:"100%",
                                height:"150px",
                            } );
                            //
                            CKEDITOR.replace( 'fact', {
                                toolbar: [
                                    ['Bold', 'Italic', 'Underline'],
                                    ['Paste', 'PasteText', 'PasteFromWord'],
                                    ['RemoveFormat']
                                ],
                                width:"100%",
                                height:"120px",
                            } );

                            if ($.fn.Browser.safari()) {
                                $("#published").datepicker({
                                    inline: true
                                });
                            }

                            $("#dragzone-image").dropster({
                                url: "/upload/image/normal/stream",
                                onUpload: $.fn.onUpload,
                                onDownload: $.fn.onDownload,
                                onReady: function (response) {
                                    // Remove the progressbar
                                    this.monitor.remove();
                                    // Reset the global imageArray
                                    imageArray = [];
                                }
                            });

                            $("#dragzone-cover").dropster({
                                url: "/upload/image/cover/stream",
                                uploadLimit: 1,
                                onUpload: $.fn.onUpload,
                                onDownload: function () {},
                                onReady: function (response) {
                                    // Remove the progressbar
                                    this.monitor.remove();
                                    var image = jQuery.parseJSON(response);
                                    if (image.error) {
                                        $.fn.createErrorMessage (Localize.getLocaleString (image.error.message));
                                    } else {
                                        $.fn.imageHandlerEvent ("cover", "display", image);
                                    }
                                }
                            });
                        });
                    </script>
                    <?php if (isset($error)) { ?>
                    <div class="modal-window">
                        <div class="modal-window-header">
                            <div class="font-icon icon-attention"></div>
                        </div>
                        <div class="modal-window-body">
                            Could not add post. An error occured: asd aasdasda asdasd <?$error['message'];?>
                        </div>
                        <div class="modal-window-footer">
                            <div class="modal-window-button dismiss">OK</div>
                        </div>
                    </div>
                    <?php } ?>
