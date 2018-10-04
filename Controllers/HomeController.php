<?php
use \System\Controller;

Class HomeController extends Controller {

    public function index() {
        parent::check_session();
        parent::check_auth(__FUNCTION__);
    }
}