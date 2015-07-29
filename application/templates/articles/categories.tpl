                    <div class="split-view">
                        <div class="left-view">

                            <div class="quick-menu">
                                <a href="/articles/archive"><div class="quick-menu-button">Archive</div></a>
                                <a href="/articles/create"><div class="quick-menu-button">Add post</div></a>
                                <a href="/articles/categories"><div class="quick-menu-button active">Categories</div></a>
                                <a href="/gallery"><div class="quick-menu-button">Gallery</div></a>
                            </div>

                            <div class="stylized-form">
                                <div class="stylized-form-header">
                                    Manage categories
                                </div>
                                <div class="stylized-form-row">
                                    <div class="label">
                                        Category name:
                                    </div>
                                    <div class="input">
                                        <input type="text" class="add-input"/>
                                    </div>
                                </div>
                                <div class="stylized-form-header">
                                    <div class="label">
                                        Click on the category name to change it. Save with the enter key or by clicking outside the text field.
                                    </div>
                                </div>
                                <?php
                                    if (empty($categories)) {
                                ?>
                                <div class="stylized-form-header">
                                    <div class="label">
                                        No categories added.
                                    </div>
                                </div>
                                <?php
                                    } else {
                                        foreach ($categories AS $category) {
                                ?>
                                <div class="stylized-form-row unboxed">
                                    <div class="label">
                                        <input type="text" class="autosave-input" data-id="<?=$category['id']?>" data-value="<?=$category['name']?>" value="<?=$category['name']?>" />
                                    </div>
                                    <div class="input">
                                        <span class="font-icon icon-cancel remove-category" data-id="<?=$category['id']?>"></span>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>

                        </div>
                        <div class="right-view">
                            <div class="searchbox">
                                   <form action="/articles/categories/search/" method="GET">
                                       <input type="search" name="search" placeholder="Search for category..." />
                                   </form>
                            </div>

                            <div class="" style="padding:25px 8px; font-family: 'Raleway', sans-serif;">
                                <div style="font-size: 14px;font-weight: bold">
                                    Most popular categories:
                                </div>
                                <div>
                                    <ul style="list-style-type:none;margin:0;padding:8px 0 0 0;">
                                        <?php
                                            if (!empty($mostUsedCategories)) {
                                                foreach ($mostUsedCategories AS $key => $category) {
                                        ?>
                                        <li style="padding:5px 0px 0 0;">&raquo; <?=$category['name']?> (<?=$category['count']?>)</li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
