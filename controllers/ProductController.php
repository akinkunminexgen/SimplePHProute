<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class ProductController extends Controller
{
  public static function doSomething($viewName){

    $product = new Product();
    $category = new Category();
    //$result = $product->firstOrDefault(['Title', 'Dark Skies']);
    $result = $product->select('Title', 'Author', 'Price')->where(['Title', 'Dark Skies'])->join($category);
   // var_dump($result->toList());
    self::view($viewName, ["resulter" => $result->toList()]);
  }
}

 ?>
