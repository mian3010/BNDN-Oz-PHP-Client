<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Rent extends Widget_Wrapper {
  public function __construct($price) {
    $b = new Widget_ThreePartButton("", "Rent", $price, "C");
    $this->widgets[] = $b;
  }
}
