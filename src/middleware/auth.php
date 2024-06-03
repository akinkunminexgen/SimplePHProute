<?php
// authMiddleware.php

class AuthMiddleware {
    public static function handle() {
        // Check if user is authenticated
        if (self::isAuthenticated()) {
            // User is authenticated, proceed to the next middleware or controller
            //return $next($request);
        } else {
            // User is not authenticated, redirect to login page or return unauthorized response
            $controller = new Controller;
            $controller->view('index');
            //header("Location: /login.php");
            exit;
        }
    }

    private static function isAuthenticated() {
        // Example: Check if user is logged in by verifying session or token
        // Replace this with your actual authentication logic
        return isset($_SESSION['user_id']); // Assuming user_id is set in the session upon login
    }
}

AuthMiddleware::handle()
?>
