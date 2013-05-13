<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_NotRentable extends Widget_Wrapper {
  public function __construct() {
    $l = new Widget_Label("Product not rentable");
    $this->widgets[] = $l;
  }
}
