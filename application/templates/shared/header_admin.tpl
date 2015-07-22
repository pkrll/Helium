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
        <script src="/public/javascript/plugins/helium.localize-1.0.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.admin.js" charset="utf-8"></script>
        <?php if ($includes) { include_once $includes; } ?>
    </head>
    <body>
        <div id="window">
            <div id="window-side-bar">
                <div id="window-side-bar-header">
                    <span class="appname long"><?=APP_NAME?></span>
                    <span class="appname short"><?=APP_NAME_SHORT?></span>
                    <span class="version">version <?=APP_VERSION?></span>
                </div>
                <nav id="menu-bar">
                    <ul class="menu-bar-ul">
                        <li class="menu-bar-li" data-href="/admin">
                            <span class="font-icon menu icon-home"></span><span class="menu-title"><a href="/admin">Dashboard</a></span>
                        </li>
                        <li class="menu-bar-li" data-href="/articles/admin">
                            <span class="font-icon menu icon-document"></span><span class="menu-title"><a href="/articles/admin">Articles</a></span>
                        </li>
                        <li class="menu-bar-li" data-href="/admin/frontpage">
                            <span class="font-icon menu icon-front"></span><span class="menu-title"><a href="/admin/frontpage">Front page</a></span>
                        </li>
                        <li class="menu-bar-li">
                            <span class="font-icon menu icon-gallery"></span><span class="menu-title">Gallery</span>
                        </li>
                        <li class="menu-bar-li" data-href="/user/admin">
                            <span class="font-icon menu icon-users"></span><span class="menu-title"><a href="/user/admin">Users</a></span>
                            </li>
                        <li class="menu-bar-li" data-href="/user/rights">
                            <span class="font-icon menu icon-eye"></span><span class="menu-title"><a href="/user/rights">Permissions</a></span>
                        </li>
                        <li class="menu-bar-li">
                            <span class="font-icon menu icon-calendar"></span><span class="menu-title">Calendar</span>
                        </li>
                        <li class="menu-bar-li" data-href="/admin/settings">
                            <span class="font-icon menu icon-settings"></span><span class="menu-title"><a href="/admin/settings">Settings</a></span>
                        </li>
                        <li class="menu-bar-li" data-href="/user/logout">
                            <span class="font-icon menu icon-logout"></span><span class="menu-title"><a href="/user/logout">Logout</a></span>
                        </li>
                    </ul>
                </nav>
            </div>
            <div id="window-content">
