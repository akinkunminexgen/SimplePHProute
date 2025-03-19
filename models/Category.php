<?php
/**
 *
 */
class Category extends Model
{
    public int $Id;
    public ?string $Name;
    public string $DisplayOrder;

  public function __construct($tableName = "Categories")
  {
    parent::__construct($tableName);
  }


  
  
}

 ?>
