<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SimpleCMS <?=APP_VERSION ?> - Admin</title>
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/admin/main.css" />
        <link href='http://fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
        <script src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script src="/public/javascript/main.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="page-header-container">
                <div id="page-header-title">
                    <h1>SimpleCMS</h1>
                        <h3>A content management system</h3>
                </div>
            </div>


            <div id="splash">
                <h1 class="splash-header"><?=SPLASH_HEADER_1?>, Ardalan!</h1>
                <h2 class="splash-header"><?=SPLASH_HEADER_2?></h2>
                <div>
                    <ul id="list-menu" style="position:relative">
                        <li>
                            <img src="/public/images/system/admin/menu/compose.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_COMPOSE;?></div>
                        </li>
                        <li>
                            <img src="/public/images/system/admin/menu/article.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_LIST_ARTICLE;?></div>
                        </li>
                        <li>
                            <img src="/public/images/system/admin/menu/front.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_EDIT_FRONT;?></div>
                        </li>
                        <li>
                            <img src="/public/images/system/admin/menu/image.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_MANAGE_GALLERY;?></div>
                        </li>
                        <li>
                            <img src="/public/images/system/admin/menu/user.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_MANAGE_USER;?></div>
                        </li>
                        <li>
                            <img src="/public/images/system/admin/menu/settings.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_SETTINGS;?></div>
                        </li>
                        <li>
                            <img src="/public/images/system/admin/menu/logout.png" />
                            <div class="label"><?=SPLASH_LIST_MENU_LOGOUT;?></div>
                        </li>
                    </ul>
                </div>
            </div>
