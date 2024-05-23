<?php
/**
 *
 */
class Routes
{
    public static $validRoutes = array();
    public static $count = 0;
    public static $url = array();


  //to group routes in different folder and also to make use of middleware
    public static function group($variables = [], $function)
    {
      if (count($variables)) {
        foreach ($variables as $key => $value) {
          switch ($key) {
            case 'prefix':
              echo $value;
              break;

              case 'namespace':
                // code...
                break;

                case 'middleware':
                  // code...
                  break;
  
            default:
              // code...
              break;
          }
        }
      }
    }

  public static function set($routes, $function)
  {
    self::$validRoutes[] = $routes;
    self::$count++;
    // to get the url parameter us as to know the specific routes
    self::$url = explode("/",$_SERVER['REQUEST_URI'],3);
   if (self::$url[2] == $routes) {
     //print_r($_SERVER['REQUEST_URI']);
      $function->__invoke(); // to run all Routes
      exit();
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
