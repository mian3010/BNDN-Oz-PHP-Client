<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Rentet extends Widget_Wrapper {
  public function __construct($purchase) {
    $b = new Widget_RoundButton("", "Download product");
    $this->widgets[] = $b;
  }
}
