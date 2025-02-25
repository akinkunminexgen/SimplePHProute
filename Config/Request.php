<?php
/**
 * 
 */

 class Request {
    public $method;
    public $next;
    public int $count = 0;
    public $headers;
    public $body;
    public bool $confirmed = false;

    public function __construct($method = "") {
        $this->method = $method;
    }
}
?>