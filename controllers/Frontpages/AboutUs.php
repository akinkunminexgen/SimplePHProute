<?php
namespace Frontpages;
use Student;// For identifying file in the subfolder
/**
 *
 */
class AboutUs extends \Controller
{
  public static function doSomething($viewName){
    
    $student = new Student();

    $result = $student->all();
    //$result = ['ade'=>'i hate you', 'bose'=>'i will lovw you forever', 'jide' => ['bola' => 'the love i have']];
    self::with(['myData'=> 'thedataenemy of le'])->view($viewName, ['resulter' => $result]);
  }
}

 ?>
