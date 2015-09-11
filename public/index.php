<?php
use hyperion\core\Bootstrap;

error_reporting(E_ERROR | E_WARNING | E_PARSE);
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
date_default_timezone_set("Europe/Stockholm");
session_start();

include_once dirname(__DIR__)."/vendor/autoload.php";
include_once dirname(__DIR__)."/library/Config.php";
include_once dirname(__DIR__)."/library/Permissions.php";

$Bootstrap = new Bootstrap();
