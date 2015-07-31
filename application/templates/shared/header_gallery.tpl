<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title><?=APP_NAME ?></title>
        <link href="/public/css/font.css" rel="stylesheet" type="text/css">
        <link href="/public/css/main.css" rel="stylesheet" type="text/css">
        <link href="/public/css/admin/main.css" rel="stylesheet" type="text/css">
        <link href="/public/css/gallery/main.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script src="/public/javascript/plugins/helium.localizer-1.0.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.js" charset="utf-8"></script>
<?php if ($includes) { include_once $includes; } ?>
    </head>
    <body style="margin:0;">
        <div id="container">
            <div class="header-bar">
                <div class="labels header-link">
<?php if (isset($upload)) { ?>
                    <a href="/gallery/browse/?CKEditor=body&amp;CKEditorFuncNum=0&amp;langCode=en"><?=LANG_BROWSE?></a>
<?php } else { ?>
                    <a href="/gallery/upload"><?=LANG_UPLOAD?></a>
<?php } ?>
                </div>

                <div class="labels searchbox">
                    <input type="search" name="search" id="search" placeholder="<?=LANG_SEARCH?>" autocomplete="off" />
                </div>
            </div>
