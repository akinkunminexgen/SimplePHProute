<?php
/**
 *
 */
class Model extends Database
{
  private $TBname;

  public function __construct($name = "name of table")
  {
    $this->TBname = $name;
  }

  public function all(){
    $sqlquery = sprintf("SELECT * FROM %s.",$this->TBname);
    return self::query($sqlquery);
    
  }
}

 ?>
