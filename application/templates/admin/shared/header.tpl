<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=APP_NAME?> <?=APP_VERSION ?> - Admin</title>
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/fonts.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/admin/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/admin/form.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/admin/progressbar-1.0.css" />
        <script src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script src="/public/javascript/helium.js"></script>
        <script src="/public/javascript/plugin/localize-1.0.js"></script>
<?php
    if (!empty($scripts)) {
        foreach ($scripts as $key => $value) {
            echo "<script src=\"/public/javascript/{$value}\"></script>";
        }
    }
?>

    </head>
    <body>
        <div id="container">
            <!-- header start -->
            <div id="page-header-container">
                <div id="page-header-title">
                    <a href="/admin/">
                        <img src="/public/images/system/admin/tmp-logo.png" style="width:48px;display:inline-block;" />
                        <h1 style="display:inline-block;vertical-align:bottom;">
                            <?=APP_NAME?>
                        </h1>
                    </a>
                </div>
            </div>
            <!-- header end -->
