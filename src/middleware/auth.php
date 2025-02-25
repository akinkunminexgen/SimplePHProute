<?php
// authMiddleware.php

class AuthMiddleware {
    
    public static function handle($request) { 
        $controller = new Controller;
        // Check if user is authenticated
        if (self::isAuthenticated()) {
            if($request->confirmed){
                $controller->view($request->next);
                exit();
            } 
        } else {
            if($request->confirmed){
                echo "This is Auth the middleware ";
                exit();
            }                
            //header("Location: /login.php");  
        }
    }

    private static function isAuthenticated() {
        // Example: Check if user is logged in by verifying session or token
        // Replace this with your actual authentication logic
        return isset($_SESSION['user_id']); // Assuming user_id is set in the session upon login
    }
}

AuthMiddleware::handle($request);
?>
