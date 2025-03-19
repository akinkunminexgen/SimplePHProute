<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class CategoryController extends Controller
{
  public static function doSomething($viewName){    
    
    $category = new Category();
    $product = new Product();
    $result = $category->find(2);
    $product->Title = $result['Name'];
    var_dump($result);
    var_dump("<br>",$product);
    self::view($viewName, ["resulter" => $result->toList()]);
  }
}

 ?>
