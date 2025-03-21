<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class CategoryController extends Controller
{
  public static function doSomething($viewName){    
    
    $category = new Category();
    $result = $category->find(2)->toList();
    //var_dump($result);
    //var_dump("<br>",$product);
    self::view($viewName, ["resulter" => $result]);
  }
}

 ?>
