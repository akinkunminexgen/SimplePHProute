<?php

class RoleMiddleware {
    
    public static function handle($request) { 
        // Check if user is authenticated
        if (self::isRole()) {
            $controller = new Controller;
            $controller->view($request["uri"]);
            exit();
        } else {
            echo "This is the Role middleware";
            //header("Location: /login.php");            
            exit();
        }
    }

    private static function isRole() {
        // Example: Check if user is logged in by verifying session or token
        // Replace this with your actual authentication logic
        return isset($_SESSION['user_id']); // Assuming user_id is set in the session upon login
    }
}

RoleMiddleware::handle(self::$request);
?>
