<?php
namespace Backpages; // For identifying file in the subfolder
/**
 *
 */
class History extends \Controller
{
  public static function doSomething($viewName){
    //$result = self::query("SELECT * FROM student WHERE lastname = 'ajayi'");
    //$result = ['ade'=>'i hate you', 'bose'=>'i will lovw you forever', 'jide' => ['bola' => 'the love i have']];
    self::view($viewName);
  }
}

 ?>
