<?php

use \System\View;
use \System\Controller;

Class HomeController extends Controller {
    public function index() {
        $user = new Users();
        $user->check_session();
        $view = new View();
        if (!isset ($_SESSION['login'])) {
            $view->render('loginView');
        } else {
            $view->render('cabinetView');
        }
    }
}