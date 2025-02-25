<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class ProductController extends Controller
{
  public static function doSomething($viewName){
    //$result = self::query("SELECT * FROM dbo.Products WHERE Author = 'Arya Stark'");
    //$result = ['ade'=>'i hate you', 'bose'=>'i will lovw you forever', 'jide' => ['bola' => 'the love i have']];

    $product = new Product();
    //$result = $products->all();

    $product->Author = "Akin Bruno";   
    $product->Title = "Money is good";
    $product->Description = "Liverpool has won it";
    $product->ISBN = "545FGD5";
    $product->ListPrice = 100.0;
    $product->Price = 60.0;
    $product->Price50 = 45.0;
    $product->Price100 = 30.0;
    $product->CategoryId = 2;
    //$result = $product->insert($product);
    $result = $product->all();
    self::view($viewName, ["resulter" => $product]);
  }
}

 ?>
