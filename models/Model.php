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

  public function find_id(int $id)
  {
    return self::query("SELECT * FROM $this->TBname WHERE id = $id");
  }

  public function where(array $value)
  {
    
    return self::query("SELECT * FROM $this->TBname WHERE $value[0] = $value[1]");
  }


}

 ?>
