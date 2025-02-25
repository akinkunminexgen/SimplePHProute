<?php
// authMiddleware.php

class AuthMiddleware {
    
    public static function handle($request) { 
        // Check if user is authenticated
        if (self::isAuthenticated()) {
            $controller = new Controller;
            $controller->view($request["uri"]);
            exit();
        } else {
            // User is not authenticated, redirect to login page or return unauthorized response
            echo "This is Auth the middleware";
            //header("Location: /login.php");            
            exit();
        }
    }

    private static function isAuthenticated() {
        // Example: Check if user is logged in by verifying session or token
        // Replace this with your actual authentication logic
        return isset($_SESSION['user_id']); // Assuming user_id is set in the session upon login
    }
}

AuthMiddleware::handle(self::$request);
?>
