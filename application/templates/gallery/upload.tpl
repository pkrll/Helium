<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title><?=APP_NAME ?> - Gallery</title>
        <link href="/public/css/font.css" rel="stylesheet" type="text/css">
        <link href="/public/css/main.css" rel="stylesheet" type="text/css">
        <link href="/public/css/gallery/main.css" rel="stylesheet" type="text/css">
        <link href="/public/css/plugins/progressbar-1.0.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="/public/javascript/plugins/helium.progressbar-1.0.js"></script>
        <script type="text/javascript" src="/public/javascript/plugins/helium.localize-1.0.js"></script>
        <script type="text/javascript" src="/public/javascript/helium.js"></script>
            <script type="text/javascript" src="/public/javascript/helium.ajax.js"></script>

            <script type="text/javascript" src="/public/javascript/helium.image.js"></script>
            <script type="text/javascript" src="/public/javascript/helium.dragdrop.js"></script>
    </head>
    <body style="margin:0;">
        <div id="container">
            <div class="header">
                <div class="labels header-link">
                    <a href="/gallery/browse/?CKEditor=body&amp;CKEditorFuncNum=0&amp;langCode=en"><?=LANG_BROWSE?></a>
                </div>

                <div class="labels searchbox">
                    <input type="search" name="search" id="search" placeholder="<?=LANG_SEARCH?>" autocomplete="off" />
                </div>
            </div>
            <div id="upload">
                <fieldset class="dragzone image-ckeditor" data-type="ckeditor">
                    <div class="dragzone">
                        <p><?=ADMIN_GALLERY_DRAGANDDROP?></p>
                        <p><?=ADMIN_GALLERY_ALLOWEDEXTS?></p>

                        <input type="file" name="image-ckeditor" id="image-ckeditor" />
        				<button class="image-event-button" data-action="upload" data-type="ckeditor"><?=LANG_UPLOAD?></button>
        			</div>
                </fieldset>
            </div>

            <div id="preview"></div>
        </div>



    	<!-- <div id="container">
            <div id="searchbox" style="">
    			<div class="labels button">
    				<a href="/gallery/browse/?CKEditor=body&amp;CKEditorFuncNum=0&amp;langCode=en"><?=LANG_BROWSE?></a>
    			</div>
    			<input type="search" name="search" id="search" placeholder="<?=LANG_SEARCH?>" style="float:right;"/>
    		</div>



    		<div id="upload">
    			<fieldset class="image-ckeditor dragzone" data-type="ckeditor">
                    <div class="dragzone">
        				<div class="image-ckeditor-input">
        					<p><?=ADMIN_GALLERY_DRAGANDDROP?></p>
        					<p><?=ADMIN_GALLERY_ALLOWEDEXTS?></p>
        				<input type="file" name="image-ckeditor" id="image-ckeditor" />
        				<button class="image-event-button" data-action="upload" data-type="ckeditor"><?=LANG_UPLOAD?></button>
        				</div>
                    </div>
    			</fieldset>

    		</div>




    	</div> -->
        <!-- <div id="progress-bar-container">
           <progress id="progress-bar" value="50" max="100" style="background-image: "></progress>
           <div class="progress-bar-label">100%</div>
       </div> -->
    </body>
</html>
