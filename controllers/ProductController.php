<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class ProductController extends Controller
{
  public static function doSomething($viewName){

    $result = Product::category()->toList();
    self::view($viewName, ["resulter" => $result]);
  }
}

 ?>
