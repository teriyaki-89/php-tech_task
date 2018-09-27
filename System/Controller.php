<?php

namespace System;

class Controller {
    public function __construct() {
        $this->view = new View();
    }
    public function sanitize ($var) {
        $var = strip_tags(trim($var));
        $var = htmlentities($var);
        return $var;
    }
}
