<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
	<title><?=APP_NAME ?> - Gallery</title>
	<link href="/public/css/fonts.css" rel="stylesheet" type="text/css">
	<link href="/public/css/main.css" rel="stylesheet" type="text/css">
    <link href="/public/css/admin/gallery.css" rel="stylesheet" type="text/css">
    <link href="/public/css/admin/progressbar-1.0.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Dosis:400,700|Ubuntu:400,500|IM+Fell+English|Laila:400,500|Oxygen|Numans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Cabin:400,700|PT+Sans+Narrow|Raleway:400,600|Karla' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/public/javascript/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/public/javascript/helium.js"></script>
    <script type="text/javascript" src="/public/javascript/helium.ajax.js"></script>
    <script type="text/javascript" src="/public/javascript/helium.gallery.js"></script>
    <script type="text/javascript" src="/public/javascript/plugin/progressbar-1.0.js"></script>
    <script type="text/javascript" src="/public/javascript/helium.imagehandler.js"></script>
    <script type="text/javascript" src="/public/javascript/helium.elements.js"></script>
    <script type="text/javascript" src="/public/javascript/helium.dragdrop.js"></script>
</head>
<body style="margin:0;">
	<div id="container">
        <div id="searchbox" style="">
			<div class="labels button">
				<a href="/admin/gallery/browse/?CKEditor=body&amp;CKEditorFuncNum=0&amp;langCode=en"><?=LANG_BROWSE?></a>
			</div>
			<input type="search" name="search" id="search" placeholder="<?=LANG_SEARCH?>" style="float:right;"/>
		</div>



		<div id="upload">
			<fieldset class="image-ckeditor dragzone">
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

        <!-- <div id="progress-bar-container">
            <progress id="progress-bar" value="50" max="100" style="background-image: "></progress>
            <div class="progress-bar-label">100%</div>
        </div> -->


	</div>


</body>
</html>
