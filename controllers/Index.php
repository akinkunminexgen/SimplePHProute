<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class Index extends Controller
{
  public static function doSomething($viewName){
    //$result = self::query("SELECT * FROM dbo.Products WHERE Author = 'Arya Stark'");
    //$result = ['ade'=>'i hate you', 'bose'=>'i will lovw you forever', 'jide' => ['bola' => 'the love i have']];

    $products = new Product();
    $result = $products->all();
    //var_dump($result);
    self::view($viewName, $result);
  }
}

 ?>
