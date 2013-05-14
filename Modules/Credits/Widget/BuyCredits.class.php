<?php

/*
 * Widget for buying credits
 */
class Credits_Widget_BuyCredits extends Widget_Container {
 public function __construct() {
 	
	$input = new Widget_InputField();
	
	$t = new Widget_ThreePartButton("", $input->ToHtml(), "&nbsp", "C");
	$t->disable = "true";
	
	$link = new Widget_Link("");
	$link->widgets[] = new Widget_Label("Buy now!");
	
	$this->widgets[] = $t;
	$this->widgets[] = $link;
  }
}
