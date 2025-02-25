<?php
//namespace Testingphp\controllers\Frontpages;
/**
 *
 */
class CategoryController extends Controller
{
  public static function doSomething($viewName){

    $category = new Category();
    $category->Name = "Gadjet";
    $category->DisplayOrder = "55";
    //$result = $category->insert($category);
    $result = $category->all();
    self::view($viewName, ["resulter" => $result]);
  }
}

 ?>
