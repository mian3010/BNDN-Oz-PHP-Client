<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Rent extends Widget_Wrapper {
  public function __construct($product) {
    $b = new Widget_ThreePartButton("/Purchase/Purchase/R:".$product->id, "Rent", $product->price->rent, "C");
    $this->widgets[] = $b;
  }
}
