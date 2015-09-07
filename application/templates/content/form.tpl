
                <?php if (isset($contents["article"]["id"])) { ?>
                <form id="form" action="/content/edit/<?=$contents["article"]["id"]?>" method="POST" data-id="<?=$contents["article"]["id"]?>">
                <?php } else { ?>
                <form id="form" action="/content/create" method="POST">
                <?php }?>
                    <div id="content">
                        <div class="content-left">

                            <div id="sub-menu">
                                <ul>
                                    <li><a href="/content/archive">Archive</a></li>
                                    <?php if (isset($contents["article"]["id"])) { ?>
                                    <li class="active">Edit post</li>
                                    <?php } else { ?>
                                    <li class="active">Add post</li>
                                    <?php } ?>
                                    <li><a href="/content/categories">Categories</a></li>
                                </ul>
                            </div>

                            <div>
                                Headline:
                                <div>
                                    <input type="text" name="headline" id="headline" required="required" data-validate="required" autocomplete="off" value="<?=$contents["article"]["headline"]?>"/>
                                </div>
                            </div>
                            <div>
                                Preamble:
                                <textarea name="preamble" id="preamble" required="required"><?=$contents["article"]["preamble"]?></textarea>
                            </div>
                            <div>
                                Body:
                                <textarea name="body" id="body" required="required"><?=$contents["article"]["body"]?></textarea>
                            </div>
                            <div id="image-cover">
                                Cover image:
                                <?php
                                    if (!empty($contents['images']['cover'])) {
                                ?>
                                <div class="showcase-cover">
                                    <img src="/public/images/uploads/cover/<?=$contents['images']['cover']['image_name']?>" />
                                    <input type="text" name="caption-cover" placeholder="Add a caption" value="<?=$contents['images']['cover']['caption']?>" />
                                    <span class="image-event-button" data-type="cover" data-action="remove" data-id="<?=$contents['images']['cover']['image']['id']?>">
                                        <span class="font-icon icon-cancel"></span> Remove
                                    </span>
                                    <input type="hidden" name="image-cover" value="<?=$contents['images']['cover']['image']['id']?>" />
                                </div>
                                <?php } else { ?>
                                    <div id="dragzone-cover"></div>
                                <?php } ?>
                            </div>
                            <div>
                                Slideshow image:
                                <div id="dragzone-image"></div>
                                <div class="showcase-image">
                                <?php
                                    if (!empty($contents["images"]["normal"]["image"])) {
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
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="content-right">
                            <div class="button-container">
                                <input type="submit" class="button publish" value="Publish">
                                <input type="button" class="button" value="Preview">
                            </div>

                            <div class="content-right-section">
                                <div>
                                    <label class="select"></label>
                                    <select name="category" data-validate="required" required="required" data-label="Choose a category">
                                        <option value="">Choose category</option>
                                        <?php
                                            foreach ($data["categories"] as $key => $value) {
                                                $selected = ($contents["article"]["category"] === $value["id"]) ? " selected" : "";
                                        ?>
                                        <option value="<?=$value['id']?>"<?=$selected?>><?=$value['name']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="select"></label>
                                    <select>
                                        <option value="">Choose theme (optional)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="content-right-section">
                                <div class="padding-right-10">
                                    <div class="bold-13">Tags</div>
                                    <div>
                                        <input type="text" name="tags" id="tags" placeholder="HTML5, PHP programming, fun..." value="<?=$contents["article"]["tags"]?>"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="bold-13">Links</div>
                                    <div class="links-container">
                                        <?php
                                            if (!empty($contents['links'])) {
                                                foreach ($contents['links'] AS $link) {
                                        ?>
                                            <input type="search" class="links" placeholder="Search for article..." autocomplete="off" value="<?=$link["headline"]?> (id:<?=$link["id"]?>)" data-edit="true" data-id="<?=$link["id"]?>"/>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <input type="search" class="links" placeholder="Search for article..." autocomplete="off" />
                                    </div>
                                    <div class="add-input" data-type="search" data-class="links" data-placeholder="Search for article..." data-parent=".links-container" data-edit="<?=$edit?>">
                                        <span>
                                            <span class="font-icon icon-plus" style="font-size:13px;"></span> Add link
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="content-right-section">
                                <div class="bold-13">Fact box</div>
                                <div>
                                    <textarea id="fact" name="fact"><?=$contents["article"]["fact"]?></textarea>
                                </div>
                            </div>

                            <div class="content-right-section">
                                <div>
                                    <div class="bold-13">Publish on</div>
                                    <div class="div-flex-space-between">
                                        <input type="date" name="published-date" class="published-date" id="published" placeholder="m/d/yyyy" data-validate="date" data-format="MM/DD/YYYY" value="<?=$contents["article"]["published"]["date"]?>"/>
                                        <input type="text" name="published-time" class="published-time" placeholder="00:00" value="<?=$contents["article"]["published"]["time"]?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="content-right-section">
                                <div>
                                    <div class="bold-13">Author</div>
                                    <div>
                                        <label class="select"></label>
                                        <select name="author">
                                        <!-- <select name="author" data-validate="required" required="required" data-label="Choose an author!"> -->
                                            <option value="">Choose author</option>
                                            <?php
                                                foreach ($data["authors"]["list"] as $key => $value) {
                                                    $selected = ($data["authors"]["current"] === $value['id']) ? " selected=\"true\"" : $selected = "";
                                            ?>
                                                <option value="<?=$value['id']?>"<?=$selected?>><?=$value['author']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if (!empty($contents['links'])) {
                            foreach ($contents['links'] AS $link) {
                    ?>
                        <input type="hidden" name="links[]" value="<?=$link["id"]?>"/>
                    <?php
                            }
                        }
                    ?>
                </form>
                <script type="text/javascript">
                $(document).ready(function() {
                    CKEDITOR.replace( 'body', {
                        toolbar: [
                            ['Bold', 'Italic', 'Underline'],
                            ['Paste', 'PasteText', 'PasteFromWord'],
                            ['RemoveFormat'],
                            ['Link', 'Unlink', 'Image'],
                            ['Format','Source'],
                        ],
                        width:"100%",
                        height:"350px",
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

                    CKEDITOR.replace( 'fact', {
                        toolbar: [
                            ['Bold', 'Italic', 'Underline'],
                            ['Paste', 'PasteText', 'PasteFromWord'],
                            ['RemoveFormat']
                        ],
                        width:"100%",
                        height:"120px",
                    } );

                    $("#dragzone-cover").dropster({
                        url: "/upload/image/cover/stream",
                        createArea: true,
                        uploadLimit: 1,
                        onUpload: $.fn.onUpload,
                        onDownload: function () { return 0; },
                        onReady: $.fn.onReadyCover
                    });

                    $("#dragzone-image").dropster({
                        url: "/upload/image/normal/stream",
                        createArea: true,
                        uploadLimit: 10,
                        onUpload: $.fn.onUpload,
                        onDownload: $.fn.onDownload,
                        onReady: $.fn.onReady
                    });

                    document.getElementById("form").addSalvation();

                });
                </script>
                <?php if (isset($error)) { ?>
                <div id="dropster-window">
                    <div class="dropster-window-header">
                        <div class="font-icon icon-attention"></div>
                    </div>
                    <div class="dropster-window-body">
                        Could not add post. An error occured: <?=$error['message'];?>
                    </div>
                    <div class="dropster-window-footer">
                        <div class="dropster-window-button dismiss">OK</div>
                    </div>
                </div>
                <?php } ?>
