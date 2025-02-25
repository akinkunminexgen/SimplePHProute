<?php
/**
 *
 */
class IndexController extends Controller
{
  public static function doSomething($viewName){

    $product = new Product();
    //$result = $products->all();

    $product->Author = "Akin Bruno";   
    $product->Title = "Money is good";
    $product->Description = "Liverpool has won it";
    $product->ISBN = "545FGD5";
    $product->ListPrice = 35.0;
    $product->Price = 30.0;
    $product->Price50 = 15.0;
    $product->Price100 = 10.0;
    $product->CategoryId = 2;
    //$result = $product->insert($product);
    $result = $product->all();
    self::view($viewName, ["resulter" => $result]);
  }
}

 ?>
