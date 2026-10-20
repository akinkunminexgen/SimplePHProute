<?php


class AuthMiddleware extends Middleware {

    protected static function isAllowed($request) {
        //your logic goes here
        return false; //isset($_SESSION['user_id']); 
    }
}

AuthMiddleware::handle($request);
?>
