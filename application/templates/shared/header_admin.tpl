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

            <div id="window-header">
                <div class="appname"><?=APP_NAME?></div>
                <div class="quick-button">
                    <span class="font-icon icon-plus"></span> <span class="quick-button-text">Add post</span>
                </div>
                <div class="user-center">
                    <div class="notification"><span class="font-icon icon-bell"></span> <span class="notification-bubble" style="background:#eee;">0</span></div>
                    <div class="user-menu">John Appleseed</div>
                </div>
            </div>

            <nav id="menu">
                <div>Dashboard</div>
                <div>Articles</div>
                <div>Front page</div>
                <div>Users</div>
                <div>Calendar</div>
                <div>Settings</div>
            </nav>
            <div id="work-area">
