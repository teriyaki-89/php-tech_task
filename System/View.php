<?php
namespace System;

Class View {
    public function render ($viewPath, $layout = null) {
        // if nothing then default layout which has template on it otherwise other template
        if ($layout === null) {
            $this->view = $viewPath;
            require_once (Views_Path . 'layout.php');

        } else if ($layout === false) {
            require_once (Views_Path . $viewPath.'.php');

        } else {
            $this->view = $viewPath;
            require_once (Views_Path . 'layout.php');
        }
    }
}
