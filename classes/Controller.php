<?php
class Controller
{
  public static $dataToSend;

  public static function CreateView($viewName){
    //self::view('./views/'.$viewName.'.php');
    //require_once './views/'.$viewName.'.php';
    static::doSomething($viewName); // this line code allow a class to do something and still render the view neccessary
  }



  public static function view($page, $variables = []){

      $pagePath = './views/';
      $pageExtension = '.php';

      if (!empty(self::$dataToSend)) {

        foreach (self::$dataToSend as $key => $value) {
          $$key= json_decode(json_encode($value));
          }
        }

      if(count($variables))
        {
          // Extract variables into the local scope
          foreach ($variables as $key => $value) {
            $$key= json_decode(json_encode($value));
            }
        }

        $pageFile = $pagePath . $page . $pageExtension;
        if (file_exists($pageFile)) {
          try {
              require_once $pageFile;
          } catch (Exception $e) {
              echo "Error while including the file: " . $e->getMessage();
          }
      } else {
        echo"this is controller ";
        var_dump($pageFile);
          require_once $pagePath . '404' . $pageExtension;
      }
        
        
    }


  public static function with($variables = []){

      if(count($variables))
      {
        self::$dataToSend = $variables;
        // Return an instance of the class to allow method chaining
        return new static();
      }
    }
}
 ?>
