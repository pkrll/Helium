<?php
// Redefine HYPERION Database constants
define("APP_NAME", "Helium");
define("APP_VERSION", "0.20.4");
define('HOSTNAME', "localhost");
define('USERNAME', "helium");
define('PASSWORD', "helium123");
define('DATABASE', "helium");

// CONSTANTS
define(MAX_WIDTH_COVER, 700);
define(MAX_WIDTH_IMAGE, 560);
define(MAX_WIDTH_THUMBNAIL, 90);
define(MAX_WIDTH_PROFILE, 150);
define(MAX_IMAGE_SIZE, 2097152);
define(IM_SIZE_EXACT, 1);
define(IM_SIZE_WIDTH, 2);
define(IM_SIZE_HEIGHT, 3);
define(IM_SIZE_CROP, 4);

define(ROOT, 		dirname(dirname(__FILE__)));
define(UPLOAD,		ROOT.'/public/images/uploads/');
define(COVERS,		UPLOAD.'cover/');
define(IMAGES,		UPLOAD.'normal/');
define(THUMBNAILS,	UPLOAD.'thumbnails/');
define(PROFILES,	UPLOAD.'profile/');
