<?php
/**
 *
 */
class Routes
{
    public static $validRoutes, $url = array();
    public static $count = 0;
    public static $routing = "";


  //to group routes in different folder and also to make use of middleware
    public static function group($variables = [], $function)
    {
      if (count($variables)) {
        foreach ($variables as $key => $value) {
          switch ($key) {
            case 'prefix':
              self::$routing = $value."/";
              break;
            case 'middleware':
              //check for a particular middleware
              require_once __DIR__.'src/middleware/'.$value.'.php';
              if(isset($variable['prefix'])){
                self::$routing = $variables['prefix'].'/';
              }
                  break;
  
            default:
              // code...
              break;
          }
        }
        $function->__invoke();
      }
    }

    private static function set($routes, $function)
    {
      self::$routing .= $routes;
      self::$validRoutes[] = self::$routing;
      self::$count++;
      // to get the url parameter as to know the specific routes
      self::$url = explode("/",$_SERVER['REQUEST_URI'],3);
      if (self::$url[2] == self::$routing) {
        //print_r($_SERVER['REQUEST_URI']);
          $function->__invoke(); // to run all Routes
          exit();
        }else {
          self::$routing = "";
        }
    }


    public static function get($routes, $function)
    {
      // confirming if the 
      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        self::set($routes, $function);
      }else {
        $controller = new Controller;
          $controller->with(["error" => "Permission denied! A get is required"])->view('404');
      }
    }

    public static function post($routes, $function)
    {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        self::set($routes, $function);
      }else {
        $controller = new Controller;
          $controller->with(["error" => "Permission denied! A post is required"])->view('404');
      }
    }


    public static function populate()
    {
      $counter = self::$count;
      if ($counter = self::$count) {
        $newRoute = false;
          if (in_array(self::$url[2], self::$validRoutes)) { //frontpages==a55
            $newRoute = true;
          }
          //to redirect to a 404 page in the view
        if (!$newRoute) {
          $controller = new Controller;
          $controller->view('404');
        }
      }
    }


}
?>
