<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class CategoryController extends Controller
{
  public static function doSomething($viewName){    
    
    //$category = new Category();
    //$category->name = "Able";
    //$category->displayOrder = 99;
    //$Insert = Category::insert($category);
    $result = Category::all();
    //var_dump($result);
    self::view($viewName, ["resulter" => $result]);
  }
}

 ?>
