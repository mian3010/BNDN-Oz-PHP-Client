<?php

/*
 * Get a Widget for showing a list of products
 */
class Product_Widget_ViewProducts extends Widget_Container {
  public function __construct($products) {
    $this->SetTitle("Product list");
    $this->AddOption("Search products", "Product/Browse/");
    $pw = new Widget_Wrapper();
    foreach ($products as $product) {
      $pw->widgets[] = new Product_Widget_SmallViewProduct($product);
    }
    $this->widgets[] = $pw;
  }
}
