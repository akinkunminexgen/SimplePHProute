<?php

class RoleMiddleware {
    
    public static function handle($request) { 
        $controller = new Controller;
        // Check if user is authenticated
        if (self::isRole()) { 
            if($request->confirmed){
                $controller->view($request->next);
                exit();
            }                   
        } else {
            if($request->confirmed){
                echo "This is the Role middleware";
            //header("Location: /login.php");            
            exit();
            }
                
        }
    }

    private static function isRole() {
        // Example: Check if user is logged in by verifying session or token
        // Replace this with your actual authentication logic
        return isset($_SESSION['user_id']); // Assuming user_id is set in the session upon login
    }
}

RoleMiddleware::handle($request);
?>
