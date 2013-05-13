<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Rentet extends Widget_Wrapper {
  public function __construct($purchase) {
    $b = new Widget_ThreePartButton("", "&nbsp;", "Download product", "&nbsp;");
    $this->widgets[] = $b;
  }
}
