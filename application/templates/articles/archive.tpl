                <div class="split-view">
                    <div class="left-view">

                        <div class="quick-menu">
                            <a href="/articles/archive"><div class="quick-menu-button active">Archive</div></a>
                            <a href="/articles/create"><div class="quick-menu-button">Add post</div></a>
                            <a href="/articles/categories"><div class="quick-menu-button">Categories</div></a>
                            <a href="/gallery"><div class="quick-menu-button">Gallery</div></a>
                            <div class="searchbox">
                                   <form action="/articles/archive/" method="GET">
                                       <input type="search" name="search" placeholder="Search article..." />
                                   </form>
                            </div>
                        </div>

                        <div class="div-table">
                            <div class="div-table-row div-table-header">
                                <div class="header-size-2">Title</div>
                                <div class="header-size-1">Author</div>
                                <div class="header-size-1">Category</div>
                                <div class="header-size-1">Created</div>
                                <div class="header-size-1">Last edit</div>
                            </div>
                            <?php
                                foreach ($articles as $key => $article) {
                            ?>
                            <div class="div-table-row div-table-content" data-id="<?=$article['id']?>">
                                <div class="header-size-2"><a href="/articles/edit/<?=$article['id']?>"><?=$article['headline']?></a></div>
                                <div class="header-size-1"><?=$article['author']?></div>
                                <div class="header-size-1"><?=$article['category']?></div>
                                <div class="header-size-1"><?=date("Y-m-d H:i", $article['created'])?></div>
                                <div class="header-size-1"><?=date("Y-m-d H:i", $article['last_edit'])?></div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                    <!-- <div class="right-view">
                        <div class="searchbox">
                           <form action="/articles/archive/search/" method="get">
                               <input type="search" name="search" placeholder="Search article..." />
                           </form>
                       </div>
                       <div style="padding:10px 0 10px 0; font-family: 'Noto Sans', sans-serif; font-size:13px;">
                           Quick menu
                           <div>
                               Add Category
                           </div>
                       </div>
                    </div> -->

                </div>


                <!-- <div class="flex-box">
                    <div class="div-table">
                        <div class="div-table-row div-table-search">
                            <div class="searchbox">
                                <form action="/articles/archive/search/" method="get">
                                    <input type="search" name="search" />
                                </form>
                            </div>
                        </div>
                        <div class="div-table-row div-table-header">
                            <div class="header-size-2">Article</div>
                            <div class="header-size-1">Author</div>
                            <div class="header-size-1">Category</div>
                            <div class="header-size-1">Created</div>
                            <div class="header-size-1">Last edit</div>
                        </div>
                <?php   foreach ($articles as $key => $article) { ?>
                        <div class="div-table-row div-table-content" data-id="<?=$article['id']?>">
                            <div class="header-size-2"><a href="/articles/edit/<?=$article['id']?>"><?=$article['headline']?></a></div>
                            <div class="header-size-1"><?=$article['author']?></div>
                            <div class="header-size-1"><?=$article['category']?></div>
                            <div class="header-size-1"><?=date("Y-m-d H:i", $article['created'])?></div>
                            <div class="header-size-1"><?=date("Y-m-d H:i", $article['last_edit'])?></div>
                        </div>
                <?php   } ?>
                    </div>
                </div> -->
