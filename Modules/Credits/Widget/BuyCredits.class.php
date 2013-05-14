<?php

/*
 * Widget for buying credits
 */
class Credits_Widget_BuyCredits extends Widget_Container {
 public function __construct() {
  $f = new Widget_Form();
  $f->id = "buy-credits";
  $f->action = UriController::GetAbsolutePath('/Credits/UpdateCredits');
  $f->method = 'POST';

  // Input field
  $input = new Widget_InputField("number");
  $input->name = "credits";
  $input->value = "50";
  $t = new Widget_ThreePartButton("", $input->ToHtml(), "&nbsp", "C");
  $t->classes[] = 'inline';
  $t->classes[] = 'hasALittleBitOfPadding';
  $t->disabled = TRUE;
  
  $cw = new Widget_Wrapper();
  $cw->classes[] = 'hasALittleBitOfPadding';
  $cw->widgets[] = $t;
  
  // Buy button
  $b = new Widget_Button("Buy now!");
  $b->AddCss('#' . $s->id . '{ width:60px; }');
  $b->classes[] = 'inline';
  $b->classes[] = 'hasALittleBitOfPadding';
  $bw = new Widget_Wrapper();
  $bw->widgets[] = $b;
	
  $f->widgets[] = $cw;
  $f->widgets[] = $bw;
  
	$this->widgets[] = $f;
 }
}
