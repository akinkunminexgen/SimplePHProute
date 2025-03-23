<?php
/**
 *
 */
class Category extends Model
{
    public int $Id;
    public ?string $Name;
    public string $DisplayOrder;
    public readonly string $primaryKey;

  public function __construct($tableName = "Categories")
  {
    $this->primaryKey = 'Id';
    parent::__construct($tableName);
    
  }


  
  
}

 ?>
