
                <div id="content">
                    <div class="content-full">
                        <div id="sub-menu">
                            <ul>
                                <li class="active">Archive</li>
                                <li><a href="/content/create">Add post</a></li>
                                <li><a href="/content/categories">Categories</a></li>
                            </ul>
                        </div>
                        <form action="/content/remove" method="POST" id="archive">
                            <div class="div-table">
                                <div class="div-table-toolbar top">
                                    <span class="font-icon remove"><span class="icon-cancel"></span> Remove</span>
                                </div>
                                <div class="div-table-row div-table-header">
                                    <div class="header-size-3">Title</div>
                                    <div class="header-size-2">Author</div>
                                    <div class="header-size-2">Category</div>
                                    <div class="header-size-2">Created</div>
                                    <div class="header-size-2">Last edit</div>
                                    <div class="header-size-1">Action</div>
                                </div>
                                <?php
                                    foreach ($articles as $key => $article) {
                                ?>
                                <div class="div-table-row div-table-content" data-id="<?=$article['id']?>">
                                    <div class="header-size-3"><a href="/content/edit/<?=$article['id']?>"><?=$article['headline']?></a></div>
                                    <div class="header-size-2"><?=$article['author']?></div>
                                    <div class="header-size-2"><?=$article['category']?></div>
                                    <div class="header-size-2"><?=date("Y-m-d H:i", $article['created'])?></div>
                                    <div class="header-size-2"><?=date("Y-m-d H:i", $article['last_edit'])?></div>
                                    <div class="header-size-1"><input type="checkbox" name="article[]" value="<?=$article["id"]?>"></div>
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="div-table-toolbar bottom">
                                    <span class="font-icon"><span class="icon-cancel"></span> Remove</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
