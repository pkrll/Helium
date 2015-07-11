<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Helium</title>
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/fonts.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/user/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/public/css/plugins/tooltip-1.0.css" />
        <script src="/public/javascript/jquery-2.1.4.min.js"></script>
        <script src="/public/javascript/plugins/helium.tooltip-1.0.js"></script>
        <script src="/public/javascript/plugins/helium.browser-1.0.js"></script>
        <script src="/public/javascript/plugins/helium.localize-1.0.js"></script>
        <script src="/public/javascript/helium.js"></script>
        <script src="/public/javascript/helium.form.js" charset="utf-8"></script>
    </head>
    <body>

        <div class="login-window" style="">
            <div class="login-window-header">
                Application access
            </div>
            <div class="login-window-input" >
                <form action="/">
                    <label>
                        <div class="login-window-input-label">Provide your <b>login credentials</b> below</div>
                        <div class="tooltip-container">
                            <input type="text" placeholder="Username" autofocus="autofocus" required="required" />
                        </div>
                    </label>
                        <div class="tooltip-container">
                            <input type="password" placeholder="Password" required="required"/>
                        </div>
                    <input type="submit" value="Login" />
                </form>
            </div>
        </div>

        <div class="bottom-label">
            <div>Helium <?=APP_VERSION?></div>
        </div>

    </body>
</html>
