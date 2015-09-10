<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=APP_NAME?> <?=APP_VERSION?></title>
        <link rel="stylesheet" href="/public/css/master.css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="/public/css/fonts.css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="/public/css/user/main.css" media="screen" charset="utf-8">
    </head>
    <body>

        <div id="window">

            <div id="login-window">
                <div id="login-window-top">Application access</div>
                <div id="login-window-content">
                    <form action="/user/login" method="POST">
                        <input name="username" placeholder="username" type="text">
                        <input name="password" placeholder="password" type="password">
                        <input type="submit" value="Login">
                    </form>
                    <?php if (isset($_errorMessage)) { ?>
                    <div id="login-window-error">
                        <?=$_errorMessage?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>
