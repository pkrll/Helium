<div class="flex-box flex-header" style="height:10%;">
    <div class="flex-box-single">
        Archive
    </div>
</div>

<div class="flex-box">
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
            <div class="header-size-1"><?=date("Y-m-d H:i", $article['created'])?></div>
        </div>
<?php   } ?>
    </div>
</div>
