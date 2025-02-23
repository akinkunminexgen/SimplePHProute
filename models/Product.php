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
    public string $ListPrice;
    public string $Price;
    public string $Price50;
    public string $Price100;
    public int $CategoryId;
    public string $ImageUrl;


     private int $speed = 0;

  public function __construct($name = "Products")
  {
    parent::__construct($name);
  }


  
  
}

 ?>
