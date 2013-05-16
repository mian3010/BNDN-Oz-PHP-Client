<?php

/*
 * Get a Widget showing a product
 */
class Product_Widget_ViewType extends Widget_Wrapper {
  public function __construct($type, $products) {
    $this->classes[] = 'hasALotOfPadding';
    $this->classes[] = 'hasALotOfBorder';
    $this->classes[] = 'hasLargeTitle';
    $this->classes[] = 'product-type';
    $this->classes[] = 'clearfix';
    $css = <<<CSS
      .product-type > h2 {
        color: #fff;
        border-bottom: 1px solid #fff;
        margin-bottom: 10px;
        font-weight: bold;
      }
CSS;
    $this->AddCss($css);
    $this->AddCss('.more-link { font-size: 15px; margin-top: 10px; color: #0f0; font-weight: bold; }');
    $this->wrapperTitle = ucfirst($type);
    foreach ($products as $product) {
      $this->widgets[] = new Product_Widget_SmallViewProduct($product);
    }
    $m = new Widget_Link('Product/ViewType/'.$type);
    $m->classes[] = 'right';
    $m->classes[] = 'more-link';
    $m->widgets[] = new Widget_Label("More");
    $this->widgets[] = $m;
  }
}
