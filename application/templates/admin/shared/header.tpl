<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=APP_NAME?> <?=APP_VERSION ?> - Admin</title>
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/admin/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/admin/form.css" />
        <link href='http://fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700|Ubuntu:400,500|IM+Fell+English|Laila:400,500|Oxygen|Numans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Cabin:400,700|PT+Sans+Narrow|Raleway:400,600|Karla' rel='stylesheet' type='text/css'>
        <script src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script src="/public/javascript/helium.js"></script>
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
