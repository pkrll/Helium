<?php
// Set level of error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// error_reporting(-1);

session_start();

define(ROOT, 		dirname(dirname(__FILE__)));
define(CONTROLLERS, ROOT.'/application/controllers');
define(MODELS,		ROOT.'/application/models');
define(VIEWS,		ROOT.'/application/views');
define(TEMPLATES,	ROOT.'/application/templates');
define(INCLUDES,	ROOT.'/application/includes');
define(LIBRARY, 	ROOT.'/library');
define(UPLOAD,		ROOT.'/public/images/uploads/');
define(COVERS,		UPLOAD.'cover/');
define(IMAGES,		UPLOAD.'normal/');
define(THUMBNAILS,	UPLOAD.'thumbnails/');
define(PROFILES,	UPLOAD.'profile/');

chdir(LIBRARY);

require_once("Config.php");
$boot = new Bootstrap();
