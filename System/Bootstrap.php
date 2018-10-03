<?php
namespace System;
defined('Site_Name') or exit( 'access denied');
use \System\Error404NotFoundController as Error404;

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
        $controller     = file_exists(Controllers_Path. $controllerName .'.php') ? new $controllerName : false;

        if ($controller !== false && is_callable($controllerName, $actionName) && method_exists($controllerName, $actionName)) {
            $controller = new $controllerName;
            $controller->{$actionName}(@$tokens);
        } else {
            $controller = new Error404;
            $controller->index();
        }
    }
}
