<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title><?=APP_NAME ?> - Gallery</title>
        <link href="/public/css/fonts.css" rel="stylesheet" type="text/css">
        <link href="/public/css/main.css" rel="stylesheet" type="text/css">
        <link href="/public/css/admin/gallery.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="/public/javascript/main.js"></script>
        <script type="text/javascript" src="/public/javascript/gallery.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700|Ubuntu:400,500|IM+Fell+English|Laila:400,500|Oxygen|Numans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Cabin:400,700|PT+Sans+Narrow|Raleway:400,600|Karla' rel='stylesheet' type='text/css'>
    </head>
    <body style="margin:0;">
    	<input type="file" name="file" style="display:none">
    	<div id="container">
    		<div id="searchbox" style="">
    			<div class="labels button">
    				<a href="/admin/gallery/?CKEditor=body&amp;CKEditorFuncNum=0&amp;langCode=en"><?=LANG_UPLOAD?></a>
    			</div>
    			<input type="search" name="search" id="search" placeholder="<?=LANG_SEARCH?>" style="float:right;"/>
    		</div>

    		<div id="gallery" class="gallery">
    			<div class="image-item header">
    				<div>&nbsp;</div>
    				<div><?=ADMIN_GALLERY_FILENAME?></div>
    				<div><?=ADMIN_GALLERY_FILESIZE?></div>
    				<div><?=ADMIN_GALLERY_FILEDATE?></div>
    			</div>
<?php
                if (isset($gallery)) {
    			    foreach ($gallery["images"] as $key => $image) {
?>
    			<div class="image-item" data-src="<?=$image['path']?>">
    				<div><img src="<?=$image['thumbnail']?>"/></div>
    				<div><?=$image["name"]?></div>
    				<div><?=$image["size"]?></div>
    				<div><?=$image["date"]?></div>
    			</div>
<?php
                    }
                }
?>
    		</div>

    		<div class="gallery" id="navigation" style="">
<?php
            if (isset($gallery)) {
        		foreach ($gallery["paging"]["navigation"] as $key => $page) {
        			if ($page === "&laquo;")
        				echo "<a href=\"?CKEditor=body&CKEditorFuncNum=0&langCode=en&page=" . ($gallery["paging"]["current"] - 1) . "\">&laquo; Tillbaka</a>";
        			else if ($page === "&raquo;")
        				echo " <a href=\"?CKEditor=body&CKEditorFuncNum=0&langCode=en&page=" . ($gallery["paging"]["current"] + 1) . "\">N&auml;sta &raquo;</a>";
        			 else if ($page === FALSE)
        				 echo "...";
        			 else if ($page == $gallery["paging"]["current"])
        				 echo " {$page} ";
        			 else
        				 echo " <a href=\"/admin/gallery/?CKEditor=body&CKEditorFuncNum=0&langCode=en&page={$page}\">{$page}</a> ";
        		}
            }
?>
    		</div>
    	</div>
    </body>
</html>
