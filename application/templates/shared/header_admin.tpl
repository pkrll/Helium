<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=APP_NAME?></title>
        <link rel="stylesheet" href="/public/css/master.css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="/public/css/fonts.css" media="screen" charset="utf-8">
        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.min.js"></script>
        <?php if(isset($includes)) include_once($includes); ?>
    </head>
    <body>
        <div id="window">
            <div id="window-top">
                <div id="header">
                    <div id="header-left">
                        <div id="app-name"><?=APP_NAME?><span style="color:#de1212">_</span></div>
                        <div style="text-align:right;font-size:14px;">Inert. Noble. Gassy.</div>
                    </div>
                    <a id="user-center" href="#">
                        <div>
                            <div style="height:64px;"><img src="/public/images/system/ninja.png" style="height:64px;"/></div>
                            <div>Ardalan Samimi</div>
                        </div>
                    </a>
                </div>
                <nav class="menu">
                    <div>
                        <a href="/admin/">Dashboard</a>
                        <a href="/content/create">Content</a>
                        <a href="/admin/frontpage">Front</a>
                        <a href="/admin/library">Library</a>
                        <a href="/admin/users">Users</a>
                        <a href="/admin/settings">Settings</a>
                    </div>
                    <div class="searchbox">
                        <input type="search" placeholder="Search..." />
                    </div>
                </nav>
            </div>

            <div id="work-area">
