<?php

/*
 * Get a small Widget of Product for showing in a list
 */
class Product_Widget_SmallViewProduct extends Widget_Wrapper {
  public function __construct($product, $buy = null, $rent = null) {
    $this->classes[] = 'clearfix';
    $this->classes[] = 'small-product';
    $this->classes[] = 'hasLargeTitle';
    $css = <<<CSS
      .small-product-text {
        height: 100px;
        margin-right: 100px;
      }
      .small-product {
        width: 453px;
        margin-right: 10px;
      }
      .small-product-inner {
        border: 1px dashed #000;
      }
      .small-product-inner img {
        margin-right: 10px;
      }
CSS;
    $this->AddCss($css);
    $this->wrapperTitle = $product->title;

    $t = new Product_Widget_ViewThumbnail($product->id);

    $tx = new Widget_Text($product->description);
    $tx->classes[] = 'small-product-text';

    $pCont = new Purchase_Controller_Default();
    $br = $pCont->BuyRent($product, $buy, $rent);
    $br->classes[] = 'right';

    $w = new Widget_Wrapper();
    $w->classes[] = 'small-product-inner';
    $w->classes[] = 'hasALittleBitOfPadding';

    $w->widgets[] = $t;
    $w->widgets[] = $br;
    $w->widgets[] = $tx;
    $this->widgets[] = $w;
  }
}
