<?php
// Configure the timezone
date_default_timezone_set("Europe/Stockholm");
// System specific constants
define('DEFAULT_CONTROLLER', 'Main');
define('DEFAULT_METHOD', 'main');
define(APP_NAME, "Helium");
define(APP_NAME_SHORT, "He");
define(APP_DESCRIPTION, "");
define(APP_VERSION, "0.9.6");

// DATABASE CONSTANTS
define(HOSTNAME, "");
define(USERNAME, "");
define(PASSWORD, "");
define(DATABASE, "");

// CONSTANTS
define(MAX_WIDTH_COVER, 700);
define(MAX_WIDTH_IMAGE, 560);
define(MAX_WIDTH_THUMBNAIL, 90);
define(MAX_IMAGE_SIZE, 2097152);
define(IM_SIZE_EXACT, 1);
define(IM_SIZE_WIDTH, 2);
define(IM_SIZE_HEIGHT, 3);
define(IM_SIZE_CROP, 4);

// REQUIRED SYSTEM FILES
require_once("core/Model.class.php");
require_once("core/View.class.php");
require_once("core/Controller.class.php");

// Classes
require_once("Database.class.php");
require_once("Session.class.php");
require_once("Image.class.php");

// Language file
include_once("language/en.lang.php");
