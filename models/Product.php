<?php
/**
 *
 */
class Product extends Model
{
    public int $Id;
    public string $Author;
    public string $Title;
    public string $Description;
    public string $ISBN;
    public float $ListPrice;
    public float $Price;
    public float $Price50;
    public float $Price100;
    public int $CategoryId;
    public ? string $ImageUrl;

  public function __construct($name = "Products")
  {
    parent::__construct($name);
  }


  
  
}

 ?>
