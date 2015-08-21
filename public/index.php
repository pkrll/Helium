<?php
use hyperion\core\Bootstrap;
// Set level of error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
// include hyperion
include dirname(__DIR__)."/vendor/autoload.php";
// redefine constants
define("APP_NAME", "Helium");
define("APP_VERSION", "0.2.0");
define('HOSTNAME', "localhost");
define('USERNAME', "helium");
define('PASSWORD', "helium123");
define('DATABASE', "helium");

// rock hard
$app = new Bootstrap();
