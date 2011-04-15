<?php
session_start();

define('ROOT_PATH', __DIR__ . '/../');
define('LIB_PATH', ROOT_PATH . 'library/');
define('TPL_PATH', ROOT_PATH . 'templates/');

define('APP_VERSION', '0.10.3');

//Define library folders
$includePaths = array();
$includePaths[] = LIB_PATH;
$includePaths[] = LIB_PATH . "vendor/";
set_include_path( get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $includePaths)  );

//Load Facebook App Config or trigger Session
if (file_exists(ROOT_PATH . 'config/config.ini.php')){
    require_once ROOT_PATH . 'config/config.ini.php';
    
    if (!defined('FACEBOOK_APP_ID')){
        define('USE_SESSION', true);
    } else {
        define('USE_SESSION', false);
    }
} else {
    define('USE_SESSION', true);
}

//Include basic files
require_once LIB_PATH . 'vendor/facebook/facebook.php';
require_once LIB_PATH . 'vendor/Zend/Loader/Autoloader.php';
require_once LIB_PATH . 'vendor/inspekt/Inspekt.php';
require_once LIB_PATH . 'vendor/Twig/Autoloader.php';


//Load an autoloader for App
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('App');
$loader->suppressNotFoundWarnings(true);
Twig_Autoloader::register();
?>

