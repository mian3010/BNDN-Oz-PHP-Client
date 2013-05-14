<?php
/*
 * Get a widget showing the accounts amount of credits
 */
class Credits_Widget_ViewCredits extends Widget_Container {
  public function __construct($c) {
	$this->c = $c;
	$this->widgets[] = new Widget_ThreePartButton("", $this->c, "C", "&nbsp;");
  }
}
