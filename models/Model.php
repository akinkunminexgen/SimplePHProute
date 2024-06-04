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

  public function all()
  {
    return self::query("SELECT * FROM $this->TBname");
  }
}

 ?>
