<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=APP_NAME?> <?=APP_VERSION?> - Admin</title>
        <link rel="stylesheet" href="/public/css/font.css" media="screen">
        <link rel="stylesheet" href="/public/css/main.css" media="screen">
        <link rel="stylesheet" href="/public/css/admin/main.css" media="screen">
        <link rel="stylesheet" href="/public/css/articles/main.css" media="screen" title="no title" charset="utf-8">
        <script src="/public/javascript/jquery-2.1.4.min.js" charset="utf-8"></script>
        <script src="/public/javascript/plugins/helium.localize-1.0.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.js" charset="utf-8"></script>
        <script src="/public/javascript/helium.admin.js" charset="utf-8"></script>
        <?php if ($include_files) include_once $include_files; ?>
    </head>
    <body>
        <div id="page-container">
            <!-- START: SIDEBAR -->
            <div id="menu-bar-container">
                <div id="menu-bar-header">
                    <a href="/admin/">
                        <?=APP_NAME?>
                    </a>
                    <span>version 0.9.6</span>
                </div>
                <div id="menu-bar">
                    <ul class="menu-bar-ul">
                        <li class="menu-bar-li" data-href="/admin/"><span class="font-icon menu icon-home"></span>Home</li>
                        <li class="menu-bar-li" data-href="open:sub-menu"><span class="font-icon menu icon-document"></span>Articles</li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/articles/create" style=""><span class="font-icon menu icon-pencil"></span>New</li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/articles/list" style=""><span class="font-icon menu icon-document"></span>Browse</li>
                        <li class="menu-bar-li" data-href="open:sub-menu"><span class="font-icon menu icon-front"></span>Front page</li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/admin/front/edit" style=""><span class="font-icon menu icon-pencil"></span>Edit</li>
                        <li class="menu-bar-li sub-menu hidden" data-href="/admin/front/add" style=""><span class="font-icon menu icon-document"></span>Add module</li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-gallery"></span>Gallery</li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-users"></span>Users</li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-calendar"></span>Calendar</li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-settings"></span>Settings</li>
                        <li class="menu-bar-li"><span class="font-icon menu icon-logout"></span>Logout</li>
                    </ul>
                </div>
            </div>
            <!-- END: SIDEBAR -->
            <div class="content-container" style="">
            <!-- START: CONTENT -->
<!--  -->
