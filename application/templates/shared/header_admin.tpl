<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=APP_NAME?> <?=APP_VERSION?></title>
        <link rel="stylesheet" href="/public/css/font.css" media="screen">
        <link rel="stylesheet" href="/public/css/main.css" media="screen">
        <link rel="stylesheet" href="/public/css/admin/main.css" media="screen">
        <link rel="stylesheet" href="/public/css/admin/responsive.css" media="screen" title="no title" charset="utf-8">
        <link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
        <script src="/public/javascript/jquery-2.1.4.min.js" charset="utf-8"></script>
        <script src="/public/javascript/plugins/helium.localizer-1.0.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.admin.js" charset="utf-8"></script>
        <?php if ($includes) { include_once $includes; } ?>
    </head>
    <body>
        <div id="window">

            <div id="window-header">
                <div class="appname"><?=APP_NAME?></div>
                <div class="quick-button">
                    <a href="/articles/create"><span class="font-icon icon-plus"></span> <span class="quick-button-text">Add post</span></a>
                </div>
                <div class="notification-center" style="position:relative;">
                    <div class="notification"><span class="font-icon icon-bell"></span> <span class="notification-bubble" style="background:#ddd;">0</span></div>
                </div>
                <div class="user-center" style="position:relative">
                    <div class="user-menu"><?=Session::get("name");?></div>
                    <div class="sub-menu">
                        <ul>
                            <li class="sub-menu-item">Profile</li>
                            <li class="sub-menu-item" data-href="/user/logout">Logout</li>
                        </ul>
                    </div>
                </div>
            </div>

            <nav id="menu">
                <a href="/admin/"><div>Dashboard</div></a>
                <a href="/articles/archive"><div<?php if($articles) echo " class='active'";?>>Posts</div></a>
                <div>Front page</div>
                <a href="/user/admin"><div>Users</div></a>
                <div>Calendar</div>
                <div>Settings</div>
            </nav>
            <div id="work-area">
