<?php

use \System\View as View;

Class HomeController extends \System\Controller {

    public function index() {
        $view = new View();
        if (!isset ($_SESSION['login'])) {
            $view->render('loginView');
        } else {
            header('Location: /users/cabinet');
        }
    }
}
