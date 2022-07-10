<?php

define('ROOT_DIR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', ROOT_DIR . DS);
define('DIR', $_SERVER['DOCUMENT_ROOT']);

$config = __DIR__ . DS . "config.php";

if(!file_exists($config)) {
header("Location: /install/");
}

ini_set("display_errors",1);
error_reporting(E_ALL);

$function = ROOT . 'core/function.php';

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once $function;
//require_once ROOT . 'core/auto-webp.php';
