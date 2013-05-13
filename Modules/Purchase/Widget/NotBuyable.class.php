<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_NotBuyable extends Widget_Wrapper {
  public function __construct() {
    $l = new Widget_Label("Product not buyable");
    $this->widgets[] = $l;
  }
}
