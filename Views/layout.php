<?php
include_once (Views_Path . 'components/header.php');
$view_file = Views_Path . $this->view.'.php';
if ( file_exists($view_file) ) {
    require_once ($view_file);
}