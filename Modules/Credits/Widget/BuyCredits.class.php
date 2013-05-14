<?php

/*
 * Widget for buying credits
 */
class Credits_Widget_BuyCredits extends Widget_Container {
 public function __construct() {
 	
	$input = new Widget_InputField();
	
	$t = new Widget_ThreePartButton("", $input->ToHtml(), "2", "3");
	$t->disable = "true";
	$this->widgets[] = $t;
	
	$this->widgets[] = new Widget_Button("Buy");
  }
}
