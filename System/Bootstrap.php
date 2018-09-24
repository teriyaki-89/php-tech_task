<?php

defined('Site_Name') or exit( 'access denied');

Class Bootstrap {

    public function __construct(){

        $tokens = explode ('/', trim($_SERVER['REQUEST_URI'] ,'/') )  ;
        //print_r ($tokens);
        $controllerName = ucfirst(array_shift( $tokens )) ?: 'HomeController' ;
        $actionName = ucfirst(array_shift( $tokens )) ?: 'index';

        if ( !file_exists('Controllers/'.$controllerName.'.php') ) {
            $controllerName ='Error404NotFoundController';
            $controller = new $controllerName;
            $controller->index();
        } else {
            $controller = new $controllerName;
            $controller->{$actionName}(@tokens);
        }




        /*$controllerName = ( ucfirst(array_shift( $tokens ) ) );
        //print_r ($controllerName);
        $flag = false;
        if (file_exists('Controllers/'.$controllerName.'.php')) {
            $controller = new $controllerName;

            if (!empty ($tokens)) {
                $actionName = ( ucfirst(array_shift( $tokens ) ) );
                //echo ($actionName);
                if (method_exists($controller, $actionName)) {
                    $controller->{$actionName}(@tokens);
                } else {

                }
            } else {
                //default action
                $controller -> index();
            }
        }  else {
            // not found controller
            $flag = true;


        }

        if ($flag && $controllerName !=='') {
            $controllerName ='Error404NotFoundController';
            $controller = new $controllerName;
            $controller->index();
        } else if  ($controllerName ==='') {
            $controllerName ='HomeController';
            $controller = new $controllerName;
            $controller->index();
        }*/

    }
}

