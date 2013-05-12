<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Buy extends Widget_Wrapper {
  public function __construct($price) {
    $b = new Widget_ThreePartButton("", "Buy", $price, "C");
    $this->widgets[] = $b;
  }
}
