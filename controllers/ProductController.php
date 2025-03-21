<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class ProductController extends Controller
{
  public static function doSomething($viewName){

    $product = new Product();
    $result = $product->firstOrDefault(['Title', 'Dark Skies']);
    self::view($viewName, ["resulter" => $result->toList()]);
  }
}

 ?>
