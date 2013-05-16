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
        margin: 10px 10px 10px 0;
        position: relative;
      }
      .small-product-inner {
        border: 1px dashed #000;
      }
      .small-product-inner img {
        margin-right: 10px;
      }
      .small-product-rating {
        position: absolute;
        right: 0;
        top: 0;
      }
CSS;
    $this->AddCss($css);
    $this->wrapperTitle = $product->title;

    $tw = new Widget_Link("Product/View/".$product->id);
    $t = new Product_Widget_ViewThumbnail($product->id);
    $t->classes[] = 'left';
    $tw->widgets = array($t);

    $r = new Product_Widget_ViewRating($product);
    $r->classes[] = 'small-product-rating';

    $tx = new Widget_Text(isset($product->description) ? $product->description : '');
    $tx->classes[] = 'small-product-text';

    if (strtolower($_SESSION['type']) == 'customer') {
      $pCont = new Purchase_Controller_Default();
      $br = $pCont->BuyRent($product, $buy, $rent);
      $br->classes[] = 'right';
    } else $br = new Widget_Wrapper();

    $w = new Widget_Wrapper();
    $w->classes[] = 'small-product-inner';
    $w->classes[] = 'hasALittleBitOfPadding';

    $w->widgets[] = $r;
    $w->widgets[] = $tw;
    $w->widgets[] = $br;
    $w->widgets[] = $tx;
    $this->widgets[] = $w;
  }
}
