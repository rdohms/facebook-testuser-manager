<?php

define('ROOT_PATH', __DIR__ . '/../');
define('LIB_PATH', ROOT_PATH . 'library/');
define('TPL_PATH', ROOT_PATH . 'templates/');

//Define library folders
$includePaths = array();
$includePaths[] = LIB_PATH;
$includePaths[] = LIB_PATH . "vendor/";
set_include_path( get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $includePaths)  );

//Include basic files
include_once ROOT_PATH . 'config/config.ini.php';
include_once LIB_PATH . 'vendor/facebook/facebook.php';
include_once LIB_PATH . 'vendor/mustache/Mustache.php';
include_once LIB_PATH . 'vendor/Zend/Loader/Autoloader.php';
include_once LIB_PATH . 'vendor/inspekt/Inspekt.php';

//Load an autoloader for App
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('App');
$loader->suppressNotFoundWarnings(true);

?>

