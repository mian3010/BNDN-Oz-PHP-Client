<?php

/*
 * Widget for buying credits
 */
class Credits_Widget_BuyCredits extends Widget_Container {
 public function __construct() {
 	$this->widgets[] = new Widget_InputField("number");
	$this->widgets[] = new Widget_Label(" C");
	
	$t = new Widget_ThreePartButton("", "1", "2", "3");
	$this->widgets[] = $t;
	
	$this->widgets[] = new Widget_Button("Buy");
  }
}
