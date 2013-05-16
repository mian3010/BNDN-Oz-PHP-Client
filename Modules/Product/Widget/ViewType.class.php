<?php

/*
 * Get a Widget showing a product
 */
class Product_Widget_ViewType extends Widget_Wrapper {
  public function __construct($type, $products) {
    $this->classes[] = 'hasALotOfPadding';
    $this->classes[] = 'hasALotOfBorder';
    $this->classes[] = 'hasLargeTitle';
    $this->classes[] = 'hasSpecialTitle';
    $this->classes[] = 'product-type';
    $this->classes[] = 'clearfix';
    $css = <<<CSS
      .product-type {
        position: relative;
      }
      .more-link {
        font-size: 15px;
        color: #0f0;
        font-weight: bold;
        position: absolute;
        bottom: 10px;
        right: 10px;
      }
CSS;
    $this->AddCss($css);
    $this->wrapperTitle = ucfirst($type);
    foreach ($products as $product) {
      $this->widgets[] = new Product_Widget_SmallViewProduct($product);
    }
    $m = new Widget_Link('Product/ViewType/'.$type);
    $m->classes[] = 'more-link';
    $m->widgets[] = new Widget_Label("More");
    $this->widgets[] = $m;
  }
}
