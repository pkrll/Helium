<?php
// Configure the timezone
date_default_timezone_set("Europe/Stockholm");
// System specific constants
define('DEFAULT_CONTROLLER', 'Main');
define('DEFAULT_METHOD', 'main');
define(APP_NAME, "SimpleCMS_APP");
define(APP_NAME_SHORT, "sCMS");
define(APP_VERSION, "0.1.1");
define(APP_CODENAME, "Cyclops");

// DATABASE CONSTANTS
define(HOSTNAME, FALSE);
define(USERNAME, FALSE);
define(PASSWORD, FALSE);
define(DATABASE, FALSE);
// REQUIRED SYSTEM FILES
require_once("core/Router.class.php");
require_once("core/Model.class.php");
require_once("core/View.class.php");
require_once("core/Controller.class.php");
require_once("Database.class.php");
require_once("Session.class.php");

include_once("language/en.lang.php");
