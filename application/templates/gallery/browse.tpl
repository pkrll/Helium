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
        				 echo " <b>{$page}</b> ";
        			 else
        				 echo " <a href=\"/gallery/browse/?CKEditor=body&CKEditorFuncNum=0&langCode=en&page={$page}\">{$page}</a> ";
        		}
            }
?>
    		</div>
