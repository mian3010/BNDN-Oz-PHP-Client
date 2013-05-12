<?php

class Widget_ClickEditField extends Widget {
  private $handler;
  public function __construct($value = ''){
    $this->value = $value;
    $this->handler = '';
  }
  
  public function addHandler($handler) {
    $this->handler = $handler;
  }

  public function GetJs() {
    $js = '$(window).load(function() {'
      . '$(".clickeditfield").click(function() {'
		    	. '$(this).css("display", "none");'
		    	. '$(this).next(".entry")'
		    	. '.val($(this).text())'
		    	. '.css("display", "")'
		    	. '.focus();'
	    	. '});'
			. '$(".clickeditfield").next(".entry").blur(function() {'
		    	. '$(this).css("display", "none");'
		    	. '$(this).prev(".clickeditfield")'
		    	. '.text($(this).val())'
		    	. '.css("display", "");'
		    	. $this->handler
     	  		. '});});';
      $this->AddJs($js);
    return parent::GetJs();
  }

  public function GetCss() {
    $this->AddCss('.clickeditfield.empty {display:inline-block; height:1em; }');
    return parent::GetCss();
  }

  public function ToHtml() {
    $label = new Widget_Label($this->value);
    $label->classes = array('clickeditfield');

    $this->classes = array('entry');
    if(trim($this->value) == '') $this->classes[] = 'empty';
    $this->style = 'display:none;';
    return 	$label->ToHtml().'<input '.$this->GetAttributes().'></input>';
  }
}
