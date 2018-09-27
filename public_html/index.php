<?php

use \System\DB as DB;
define ('Site_Name','testMVC');
session_start();

define ('Doc_root', $_SERVER["DOCUMENT_ROOT"]);
define('Controllers_Path', Doc_root.'/../Controllers/');
define('System_Path', Doc_root.'/../System/');
define('Views_Path', Doc_root.'/../Views/');

$dirs = array(System_Path, Controllers_Path);
foreach ($dirs as $dir ) {
    $files = glob( $dir . '*.php');
    foreach ($files as $file) {
        require_once($file);
    }
}

new \System\Bootstrap();
new \System\View();



