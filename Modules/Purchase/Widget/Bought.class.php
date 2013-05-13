<?php
/*
 * Buy/Rent widget
 */
class Purchase_Widget_Bought extends Widget_Wrapper {
  public function __construct($purchase) {
    $w = new Widget_Wrapper();
    $b = new Widget_ThreePartButton("", "&nbsp;", "Download product", "&nbsp;");
    $w->widgets[] = $b;
    $l = new Widget_Label("Expires: Never");
    $this->widgets[] = $w;
    $this->widgets[] = $l;
  }
}
