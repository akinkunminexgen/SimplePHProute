<?php
/**
 *
 */
class Routes
{
    public static $validRoutes, $url, $request = array();
    public static $count = 0;
    public static $routing, $theGroupRoute, $existingGroupRoute = "";
    public static $check, $checkMidleware = false;
    
    
    //this should be used when you will like to activate a middleware in a group
    public static function enableMiddleware(){
      self::$checkMidleware = true;
    }

    // this must be used to end the routes in a group
    public static function groupEnd(){
      self::$routing = "";
      self::$checkMidleware = false;
      self::$existingGroupRoute = "";
    }


  //to group routes in different folder and also to make use of middleware
    public static function group($variables, $function)
    {
      self::$routing = "";
      self::$existingGroupRoute .= self::$routing;
      if(isset($variables['prefix'])){
        self::$existingGroupRoute .= $variables['prefix']."/";
        self::$routing = self::$existingGroupRoute;
      }
      
          if(self::$checkMidleware){
            $url = explode("/",$_SERVER['REQUEST_URI']);
            if($url[1].'/' != self::$routing){
              self::groupEnd();
              return; //this is to ensure that Middleware is only excuted for the right route
            }
            
            if(isset($variables['middleware'])){ 
              $middlewareList = $variables['middleware'];
              $middlewareList = explode(';', $middlewareList);

              $number = count($middlewareList);
              $request = new Request($_SERVER['REQUEST_METHOD']); 
              foreach($middlewareList as $middleware)
              {
                $middlewareFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'middleware'.DIRECTORY_SEPARATOR.$middleware.'.php';

                if (file_exists($middlewareFile)) 
                {
                  
                  $request->next = $_SERVER['REQUEST_URI'];
                  $request->count++;
                  if($request->count == $number){
                    $request->confirmed = true;
                  }
                  require_once $middlewareFile;
                } 
                else {
                      throw new RuntimeException("Middleware file not found: $middlewareFile");
                    }                
              }

              
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
      $verifyIndex = false; //to check for route that has / alone and map it to index in the view
      if($routes == '/'){
        $verifyIndex = true;
        $routes = 'index';
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
      if($verifyIndex)
        self::$url[1] .= "/index";

      if (self::$url[1] == self::$routing) {
        //var_dump("checking", self::$validRoutes);
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

    
    //this must be used to allow all routes to populate and it must be the route on the routing script
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
          //echo '<prev>'.var_dump("this is self routing", self::$validRoutes).'</prev>';
          $controller->view('404');
        }
      }
    }


}
?>
