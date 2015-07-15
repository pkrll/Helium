<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=APP_NAME?> <?=APP_VERSION?> - Admin</title>
        <link rel="stylesheet" href="/public/css/font.css" media="screen">
        <link rel="stylesheet" href="/public/css/main.css" media="screen">
        <link rel="stylesheet" href="/public/css/admin/main.css" media="screen">
        <link rel="stylesheet" href="/public/css/admin/responsive.css" media="screen" title="no title" charset="utf-8">
        <script src="/public/javascript/jquery-2.1.4.min.js" charset="utf-8"></script>
        <script src="/public/javascript/plugins/helium.localize-1.0.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.admin.js" charset="utf-8"></script>
        <?php if ($includes) { include_once $includes; } ?>
    </head>
    <body>
        <div id="page-container">
            <!-- START: SIDEBAR -->
            <div id="menu-bar-container">
                <div id="menu-bar-header">
                    <a href="/admin/">
                        <span class="appname long"><?=APP_NAME?></span><span class="appname short"><?=APP_NAME_SHORT?></span><span>version <?=APP_VERSION?></span>
                    </a>
                </div>
                <div id="menu-bar">
                    <ul class="menu-bar-ul">
                        <li class="menu-bar-li" data-href="/admin/"><span class="font-icon menu icon-home"></span><span class="menu-title">Home</span></li>
                        <li class="menu-bar-li" data-href="open:sub-menu"><span class="font-icon menu icon-document"></span><span class="menu-title">Articles</span></li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/articles/create" style=""><span class="font-icon menu icon-pencil"></span><span class="menu-title">New</span></li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/articles/archive" style=""><span class="font-icon menu icon-box"></span><span class="menu-title">Archive</span></li>
                        <li class="menu-bar-li" data-href="open:sub-menu"><span class="font-icon menu icon-front"></span><span class="menu-title">Front page</span></li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/admin/front/edit" style=""><span class="font-icon menu icon-pencil"></span><span class="menu-title">Edit</span></li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/admin/front/add" style=""><span class="font-icon menu icon-tools"></span><span class="menu-title">Modules</span></li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-gallery"></span><span class="menu-title">Gallery</span></li>
                        <li class="menu-bar-li" data-href="open:sub-menu"><span class="font-icon menu icon-users"></span><span class="menu-title">Users</span></li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/users/edit" style=""><span class="font-icon menu icon-user"></span><span class="menu-title">Edit</span></li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/users/add" style=""><span class="font-icon menu icon-user-add"></span><span class="menu-title">Add</span></li>
                        <li class="menu-bar-li" data-href="/users/rights"><span class="font-icon menu icon-eye"></span><span class="menu-title">Permission</span></li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-calendar"></span><span class="menu-title">Calendar</span></li>
                        <li class="menu-bar-li" data-href="/settings"><span class="font-icon menu icon-settings"></span><span class="menu-title">Settings</span></li>
                        <li class="menu-bar-li" data-href="/user/logout"><span class="font-icon menu icon-logout"></span><span class="menu-title">Logout</span></li>
                    </ul>
                </div>
            </div>
            <!-- END: SIDEBAR -->
            <div class="content-container">
            <!-- START: CONTENT -->
