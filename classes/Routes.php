<?php
/**
 *
 */
class Routes
{
    public static $validRoutes, $url = array();
    public static $count = 0;
    public static $routing, $theGroupRoute = "";
    public static $check = false;
    


  //to group routes in different folder and also to make use of middleware
    public static function group($variables, $function)
    {
      self::$routing = "";

      if(isset($variables['prefix'])){
        self::$routing = $variables['prefix']."/";
      }

      if(isset($variables['middleware'])){
        
        $middlewareFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'middleware'.DIRECTORY_SEPARATOR.$variables['middleware'].'.php';

        if (file_exists($middlewareFile)) {
              require_once $middlewareFile;
            } else {
                throw new RuntimeException("Middleware file not found: $middlewareFile");
            }
      }

      $function->__invoke();
    }

    private static function set($routes, $function)
    {
      //ensuring all group routes are verified to accomodate other routes
      $groupUrl = explode("/",$_SERVER['REQUEST_URI']);
      if ($groupUrl[1].'/' != self::$routing) {
        if(self::$routing != ""){
          self::$check = true;
          self::$theGroupRoute = self::$routing ;
        }else{
          self::$routing = "";
        }        
      }
      self::$routing .= $routes;
      if(self::$check)
      {
        self::$theGroupRoute.= $routes;
        self::$validRoutes[] = self::$theGroupRoute;
        self::$check = false;
      }else{
        self::$validRoutes[] = self::$routing;
      }
      
      self::$count++;
      // to get the url parameter as to know the specific routes
      self::$url = explode("/",$_SERVER['REQUEST_URI'],2);
      if (self::$url[1] == self::$routing) {
        //print_r(self::$validRoutes);
          $function->__invoke(self::$routing); // to run all Routes
          exit();
        }else {
          self::$routing = str_replace($routes,"",self::$routing);
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
          if (in_array(self::$url[1], self::$validRoutes)) { //frontpages==a55
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
