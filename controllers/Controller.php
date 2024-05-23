<?php
class Controller extends Database
{

  public static function CreateView($viewName){
    //self::view('./views/'.$viewName.'.php');
    //require_once './views/'.$viewName.'.php';
    static::doSomething($viewName); // this line code allow a class to do something and still render the view neccessary
  }



    public static function view($page, $variables = [])
      {
        $page0 = './views/';
        $page2 = '.php';


          if(count($variables))
          {
            foreach ($variables as $key => $value) {
              $$key= json_decode(json_encode($variables[$key]));
             }
          }
          require_once $page0.$page.$page2;
      }


      public static function with($variables = [])
        {
            if(count($variables))
            {
              $variables= json_decode(json_encode($variables));;
              //var_dump($variables->myData);
            }
        }
}
 ?>
