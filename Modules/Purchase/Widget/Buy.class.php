<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Buy extends Widget_Wrapper {
  public function __construct($product) {
    $b = new Widget_ThreePartButton("/Purchase/Purchase/B:".$product->id, "Buy", $product->price->buy, "C");
    $this->widgets[] = $b;
  }
}
