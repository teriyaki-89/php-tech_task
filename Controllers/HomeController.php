<?php
session_start();

Class HomeController extends Controller {

    public function index() {

        if (!isset ($_SESSION['login'])) {
            $this->view->render('loginView');
        } else {
            $this->view->render('noView');
        }


    }


}

?>