<?php
Class View {

    public function render ($viewPath, $layout = null) {
        // if nothing then default layout which has template on it otherwise other template
        if ($layout === null) {
            $this->view = $viewPath;
            require ('views/layout.php');

        } else if ($layout === false) {
            require ('views/'.$viewPath.'.php');

        } else {
            $this->view = $viewPath;
            require ('views/layout.php');
        }

    }
}

?>