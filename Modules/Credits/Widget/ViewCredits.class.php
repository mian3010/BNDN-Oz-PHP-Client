<?php
/*
 * Get a widget showing the accounts amount of credits
 */
class Credits_Widget_ViewCredits extends Widget_Container {
  public function __construct($c) {
    if(isset($c)) { $this->c = $c; } else { $this->c = 0; }
    $this->widgets[] = new Widget_ThreePartButton('/Credits/BuyCredits', "&nbsp;", $this->c, "C");
  }
}