
                <div id="content">
                    <div class="content-left">
                        <div id="sub-menu">
                            <ul>
                                <li><a href="/content/archive">Archive</a></li>
                                <li><a href="/content/create">Add post</a></li>
                                <li class="active">Categories</li>
                            </ul>
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
                                    <input type="text" class="input-categories"/>
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
                    <div class="content-right">
                        <div class="searchbox">
                               <form action="/content/categories/search/" method="GET">
                                   <input type="search" name="search" placeholder="Search for category..." />
                               </form>
                        </div>
                        <div class="content-right-section">
                            <div class="padding-right-10">
                                <div class="bold-13">Tags</div>
                                <ul>
                                    <?php
                                        if (!empty($mostUsedCategories)) {
                                            foreach ($mostUsedCategories AS $key => $category) {
                                    ?>
                                    <li>&raquo; <?=$category['name']?> (<?=$category['count']?>)</li>
                                    <?php
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
