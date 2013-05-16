<?php

/*
 * Get a Widget showing a product
 */
class Product_Widget_ViewType extends Widget_Wrapper {

  public function __construct($type, $products) {
    $this->classes[] = 'hasALotOfPadding';
    $this->classes[] = 'hasALotOfBorder';
    $this->classes[] = 'hasLargeTitle';
    $this->wrapperTitle = ucfirst($type);
    foreach ($products as $product) {
      $this->widgets[] = new Product_Widget_SmallViewProduct($product);
    }
  }
}
