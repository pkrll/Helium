                <form id="article" action="/articles/create" method="POST">
                    <div class="flex-box flex-header" style="height:10%;">
                        <div class="flex-box-single">
                            Edit article
                        </div>
                    </div>

                    <div class="flex-box" style="">
                        <div class="flex-box-left">
                            <fieldset class="left">
                                <legend>Headline</legend>
                                <div class="tooltip-container">
                                    <input maxlength="140" type="text" name="headline" id="headline" autocomplete="off" required="required" value="<?=$article["headline"]?>"/>
                                </div>
                                <div class="add-input" data-type="text" data-name="small-headline" data-id="smallHeadline" data-remove="true" data-legend="Small headline">
                                    <span class="font-icon icon-plus"></span> Add small headline
                                </div>
                            </fieldset>

                            <fieldset class="left textarea">
                                <legend>Preamble</legend>
                                <div class="tooltip-container">
                                    <textarea name="preamble" id="preamble" required="required"><?=$article['preamble']?></textarea>
                                </div>
                            </fieldset>

                            <fieldset class="left textarea">
                                <legend>Body</legend>
                                <div class="tooltip-container">
                                    <textarea name="body" id="body" required="required"><?=$article['body']?></textarea>
                                </div>
                            </fieldset>

                            <fieldset class="dragzone left image-slideshow" data-type="slideshow">
                                <legend>Slideshow</legend>
                                <div class="dragzone">
                                    <div>Upload image by dragging it onto this field, or use the button below.</div>
                                    <div class="browse-box">
                                        <input type="file" id="image-slideshow" />
                                        <button class="image-event-button" data-type="slideshow" data-action="upload">Upload</button>
                                    </div>
                                    <div class="gallery-box">
                                        <span class="gallery">
                                            <span class="font-icon icon-gallery"></span>Choose from gallery
                                        </span>
                                    </div>
                                </div>
                            <?php
                                if (!empty($images['slide'])) {
                            ?>
                                <div class="picture-box-container">
                            <?php
                                    foreach ($images['slide'] AS $image) {
                                        if ($image['type'] === "slideshow") {
                            ?>
                                <div class="picture-box" data-id="<?=$image['id']?>">
                                    <div class="picture">
                                        <img src="/public/images/uploads/thumbnails/<?=$image['image_name']?>" />
                                    </div>
                                    <div class="caption">
                                        <span class="image-event-button" data-type="slideshow" data-action="remove" data-id="<?=$image['id']?>"><span class="font-icon icon-cancel-circled"></span>Ta bort bild</span>
                                        <div>
                                            <input type="text" name="caption-slideshow[]" placeholder="Caption" value="<?=$image['caption']?>">
                                            <input type="hidden" name="image-slideshow[]" value="<?=$image['id']?>">
                                        </div>
                                    </div>
                                </div>
                            <?php
                                        }
                                    }
                            ?>
                                </div>
                            <?php
                                }
                            ?>
                            </fieldset>

                        </div>

                        <div class="flex-box-right" style="">

                            <div id="buttons" class="section">
                                <!-- <div class="button publish">Publish</div> -->
                                <input type="submit" class="button publish" value="Publish" />
                                <input type="button" class="button preview" value="Preview" />
                            </div>

                            <div class="section">
                                <fieldset>
                                    <legend class="section-label">taxonomy</legend>
                                    <div class="subsection">
                                        <label class="select tooltip-container">
                                            <select name="category" id="category" required="required">
                                                <option value="">Choose category</option>
                                            <?php
                                                foreach ($categories as $key => $value) {
                                                    $selected = ($article['category'] == $value['id']) ? " selected" : "";
                                            ?>
                                                <option value="<?=$value['id']?>"<?=$selected?>><?=$value['name']?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="subsection">
                                        <label class="select">
                                            <select name="theme" id="theme">
                                                <option value="">Choose theme (optional)</option>
                                                <option value="1">Theme 1</option>
                                                <option value="2">Theme 2</option>
                                                <option value="3">Theme 3</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="subsection">
                                        <label>
                                            <div class="subsection-label">Tags</div>
                                            <input type="text" name="tags" id="tags" placeholder="HTML5, PHP programming, fun ..." value="<?=$article['tags']?>"/>
                                        </label>
                                    </div>

                                    <div class="subsection">
                                        <label>
                                            <div class="subsection-label">Internal links</div>
                                        </label>
                                    <?php
                                        if (!empty($links)) {
                                            foreach ($links AS $link) {
                                    ?>
                                        <div class="links-container">
                                            <input type="search" class="links" placeholder="Search for article..." autocomplete="off" value="<?=$link['headline']?> (id:<?=$link['id']?>)"/>
                                            <input type="hidden" name="links[]" value="<?=$link['id']?>"/>
                                        </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                        <div class="add-input" data-type="search" data-class="links" data-placeholder="Search for article...">
                                            <span class="font-icon icon-plus"></span> Add link
                                        </div>
                                    </div>

                                </fieldset>
                            </div>

                            <div class="section">
                                <fieldset class="dragzone right image-cover" data-type="cover">
                                    <legend class="section-label">cover image</legend>
                                <?php
                                    if (!empty($images['cover'])) {
                                ?>
                                    <div class="picture-box cover">
                                        <div class="picture">
                                            <img src="/public/images/uploads/cover/<?=$images['cover']['image_name']?>" />
                                        </div>
                                        <div class="caption">
                                            <div>
                                                <input type="text" name="caption-cover" placeholder="Caption" value="<?=$images['cover']['caption']?>" />
                                                <input type="hidden" name="image-cover" value="<?=$images['cover']['id']?>" />
                                            </div>
                                            <div>
                                                <span class="image-event-button" data-type="cover" data-action="remove">Remove image</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    } else {
                                ?>
                                    <div class="dragzone">
                                        <div>Upload image by dragging it onto this field, or use the button below.</div>
                                        <div class="browse-box">
                                            <input type="file" id="image-cover" />
                                            <button class="image-event-button" data-type="cover" data-action="upload">Upload</button>
                                        </div>
                                        <div class="gallery-box">
                                            <span class="gallery">
                                                <span class="font-icon icon-gallery"></span>Choose from gallery
                                            </span>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                                </fieldset>
                            </div>

                            <div class="section">
                                <fieldset>
                                    <legend class="section-label">extra</legend>
                                    <div class="subsection">
                                        <label>
                                            <div class="subsection-label">Fact box</div>
                                            <textarea name="fact" id="fact"><?=$article['fact']?></textarea>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="section">
                                <fieldset>
                                    <legend class="section-label">publishing options</legend>
                                    <div class="subsection">
                                        <label>
                                            <div class="subsection-label">Publish on</div>
                                            <input type="date" name="published-date" class="published-date" id="published" placeholder="dd/mm/yyyy" value="<?=$article['published']['date']?>"/>
                                        </label>
                                        <input type="time" name="published-time" class="published-time" placeholder="00:00" value="<?=$article['published']['time']?>"/>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="section">
                                <fieldset>
                                    <legend class="section-label">authoring information</legend>
                                    <div class="subsection">
                                        <label class="select">
                                            <select name="author" id="author">
                                                <option value="">Choose author</option>
                                            <?php
                                                foreach ($users["users"] as $key => $value) {
                                                    $selected = ($article['author_id'] === $value['id']) ? " selected=\"true\"" : "";
                ?>
                                                <option value="<?=$value['id']?>"<?=$selected?>><?=$article['author']?></option>
                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                        </div>

                    </div>
                </form>
                <script>
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
                        height:"130px",
                    } );

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
                </script>
                <?php if (isset($error)) { ?>
                <div class="overlay-300-center">
                    <div>
                        <div class="font-icon icon-attention icon"></div>
                        <div class="warning">The article could not be added proberly. An error occurred:</div>
                    </div>
                    <div class="description">
                        <?=$error["message"];?>
                    </div>
                    <div class="button default dismiss">Dismiss</div>
                </div>
                <?php } ?>
