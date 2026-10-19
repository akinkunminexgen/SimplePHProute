<?php
// authMiddleware.php

class Middleware {
    
    public static function handle($request) { 
        $controller = new Controller;
        // Check if user is authenticated
        if (static::isAllowed($request)) {
            if($request->confirmed){

                //$controller->view($request->next);
                //exit();
            } 
        } else {
                $controller->view('403');
                exit();             
            //header("Location: /login.php");  
        }
    }
}


?>
