<?php

defined('Site_Name') or exit( 'access denied');

Class Bootstrap
{
    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $tokens         = explode('/', trim($_SERVER['REQUEST_URI'] ,'/'));
        $controllerName = ucfirst(array_shift( $tokens )) ?: 'HomeController';
        $actionName     = ucfirst(array_shift( $tokens )) ?: 'index';
        $controller     = file_exists('Controllers/'.$controllerName.'.php') ? new $controllerName : false;

        if ($controller !== false && method_exists($controller, $actionName)) {
            $controller = new $controllerName;
            $controller->{$actionName}(@tokens);
        } else {
            $controllerName ='Error404NotFoundController';
            $controller = new $controllerName;
            $controller->index();
        }
    }
}

