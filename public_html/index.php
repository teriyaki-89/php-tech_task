<?php
if (!isset($_SESSION)) {
    session_start();
    session_write_close();
}
use \System\DB;
use \System\Bootstrap;
use \System\View;

define ('Site_Name','testMVC');
define ('Doc_root', $_SERVER["DOCUMENT_ROOT"]);
define('Controllers_Path', Doc_root.'/../Controllers/');
define('System_Path', Doc_root.'/../System/');
define('Views_Path', Doc_root.'/../Views/');
$dirs = [System_Path, Controllers_Path];
foreach ($dirs as $dir ) {
    $files = glob( $dir . '*.php');
    foreach ($files as $file) {
        require_once($file);
    }
}
new Bootstrap();
new View();