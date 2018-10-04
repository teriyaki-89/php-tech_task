<?php
namespace System;

class Controller {

    public function __construct() {
        $this->user['u_id']  = $_SESSION['u_id'] ?: false;
    }

    public function sanitize ($var) {
        $var = strip_tags(trim($var));
        $var = htmlentities($var);
        return $var;
    }

    public function check_auth ($method){
        if ( !isset($_SESSION['login']) ) {
            if ($method !== 'login' && $method !== 'auth' ) {
                exit(header("Location: /users/auth"));
            }
        } else {
            if ($method == 'index'){
                $view = new View();
                $view->render('cabinetView');
            } elseif (($method == 'login' or $method == 'auth')) {
                exit(header("Location: /users/cabinet"));
            }
        }
    }

    public function check_session() {
        //regenerate new session every 20 minutes
        if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 60*20) {
            session_destroy();
            session_start();
            session_regenerate_id();
            session_write_close();
        }
    }
}
