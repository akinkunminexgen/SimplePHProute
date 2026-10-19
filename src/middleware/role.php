<?php

class RoleMiddleware extends Middleware {    

    protected static function isAllowed ($request) {
        return true;
    }
}

RoleMiddleware::handle($request);
?>
