                <form id="article" action="/articles/edit/<?=$contents["article"]["id"]?>" method="POST">
                    <div class="split-view">

                        <div class="left-view">

                            <div style="font-family: 'Dosis', sans-serif; font-size: 24px; margin-bottom: 18px;">
                                <span class="font-icon icon-document"></span> New post
                            </div>

                            <div class="view-section">
                                <label>
                                    <span class="section-label">Headline</span>
                                    <input type="text" name="headline" id="headline" required="required" value="<?=$contents["article"]["headline"]?>" />
                                </label>
                                <div class="add-input" data-type="text" data-name="small-headline" data-id="smallHeadline" data-remove="true" data-legend="Small headline">
                                    <span class="font-icon icon-plus"></span> Blurb headline
                                </div>
                            </div>

                            <div class="view-section">
                                <label>
                                    <span class="section-label">Preamble</span>
                                    <textarea name="preamble" id="preamble" required="required"><?=$contents["article"]["preamble"]?></textarea>
                                </label>
                            </div>

                            <div class="view-section">
                                <label>
                                    <span class="section-label">Body</span>
                                    <textarea name="body" id="body" required="required"><?=$contents["article"]["body"]?></textarea>
                                </label>
                            </div>

                            <div class="view-section">
                                <span class="section-label">Slideshow</span>
                                <fieldset class="dragzone left image-slideshow" data-type="slideshow">
                                    <div class="dragzone">
                                        <div>Upload image by dragging it onto this field, or use the options below.</div>
                                        <div class="browse-box">
                                            <input type="file" id="image-slideshow" />
                                            <button class="image-event-button" data-type="slideshow" data-action="upload">Upload</button>
                                        </div>

                                        <div class="gallery-box">
                                            <span class="gallery">
                                                <span class="font-icon icon-gallery"></span> Choose from gallery
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="view-section left picture-box">
                                <?php
                                    if (!empty($contents["images"]["slide"])) {
                                ?>
                                    <span class="section-label">Uploaded images</span>
                                <?php
                                    foreach ($contents["images"]["slide"] AS $key => $image) {
                                ?>
                                    <div class="picture" data-id="<?=$image['id']?>">
                                        <div class="picture-container">
                                            <img src="/public/images/uploads/thumbnails/<?=$image['image_name']?>"/>
                                        </div>
                                        <div class="caption">
                                            <span class="image-event-button" data-type="slideshow" data-action="remove" data-id="<?=$image['id']?>" data-edit="true">
                                                <span class="font-icon icon-cancel"></span> Remove
                                            </span>
                                            <span class="section-label">Caption:</span>
                                            <input type="text" name="caption-slideshow[]" placeholder="Caption" value="<?=$image["caption"]?>">
                                            <input type="hidden" name="image-slideshow[]" value="<?=$image['id']?>">
                                        </div>
                                    </div>
                                <?php
                                    }
                                    }
                                ?>
                                </div>
                            </div>

                        </div>

                        <div class="right-view">
                            <div class="view-section buttons">
                                <input type="submit" class="button publish" value="Publish" />
                                <input type="button" class="button preview" value="Preview" />
                            </div>

                            <div class="view-section plaque">
                                <legend class="section-label">Taxonomy</legend>
                                <div class="subsection">
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
                                        <input type="text" name="tags" id="tags" placeholder="HTML5, PHP programming, fun ..." value="<?=$contents["article"]["tags"]?>"/>
                                    </label>
                                </div>

                                <div class="subsection">
                                    <label>
                                        <div class="subsection-label">Internal links</div>
                                    </label>
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

                            <div class="view-section plaque right picture-box">
                                <legend class="section-label">Cover image</legend>
                                <?php
                                    if (!empty($contents["images"]["cover"])) {
                                ?>
                                <div class="picture">
                                    <div class="picture-container">
                                        <img src="/public/images/uploads/cover/<?=$contents['images']['cover']['image_name']?>" />
                                    </div>
                                    <div class="caption">
                                        <div>
                                            <input type="text" name="caption-cover" placeholder="Caption" value="<?=$contents['images']['cover']['caption']?>" />
                                            <input type="hidden" name="image-cover" value="<?=$contents['images']['cover']['id']?>" />
                                        </div>
                                        <div>
                                            <span class="image-event-button" data-type="cover" data-action="remove" data-id="<?=$contents['images']['cover']['id']?>">
                                                <span class="font-icon icon-cancel"></span> Remove
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    } else {
                                ?>
                                <fieldset class="dragzone right image-cover" data-type="cover">
                                    <div class="dragzone">
                                        <div>Upload image by dragging it onto this field, or use the options below.</div>
                                        <div class="browse-box">
                                            <input type="file" id="image-cover" />
                                            <button class="image-event-button" data-type="cover" data-action="upload">Upload</button>
                                        </div>

                                        <div class="gallery-box">
                                            <span class="gallery">
                                                <span class="font-icon icon-gallery"></span> Choose from gallery
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                                <?php
                                    }
                                ?>

                            </div>

                            <div class="view-section plaque">
                                <legend class="section-label">Extras</legend>
                                <div class="subsection">
                                    <label>
                                        <div class="subsection-label">Fact box</div>
                                        <textarea name="fact" id="fact"><?=$contents["article"]["fact"]?></textarea>
                                    </label>
                                </div>
                            </div>

                            <div class="view-section plaque">
                                <legend class="section-label">Publishing options</legend>
                                <div class="subsection">
                                    <label>
                                        <div class="subsection-label">Publish on</div>
                                        <input type="date" name="published-date" class="published-date" id="published" placeholder="m/d/yyyy" value="<?=$contents["article"]["published"]["date"]?>"/>
                                    </label>
                                    <input type="time" name="published-time" class="published-time" placeholder="00:00" value="<?=$contents["article"]["published"]["time"]?>"/>
                                </div>
                            </div>

                            <div class="view-section plaque">
                                <legend class="section-label">Authoring information</legend>
                                <div class="subsection">
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
