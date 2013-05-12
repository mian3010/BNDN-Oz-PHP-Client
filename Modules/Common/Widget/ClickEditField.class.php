<?php

class Widget_ClickEditField extends Widget {
  public function __construct($value = ''){
    $this->value = $value;
	  $this->handler = '';
    $this->AddJsFile('jquery-2.js');
  }
  
  public function addHandler($handler) {
  	$this->handler = $handler;
  }
  
  public function ToHtml() {
    if(trim($this->value) == '') $this->AddCss('#' . $this->id . '{display:inline-block; height:1em; }');

    return 	'<label id="' . $this->id . '">' . $this->value . '</label>'
			. '<input id="' . $this->id . '_entry" style="display:none;"></input>'
			. '<script>'
			. '$("#'.$this->id.'").click(function() {'
		    	. '$("#'.$this->id.'").css("display", "none");'
		    	. '$("#'.$this->id.'_entry")'
		    	. '.val($("#'.$this->id.'").text())'
		    	. '.css("display", "")'
		    	. '.focus();'
	    	. '});'
			. '$("#'.$this->id.'_entry").blur(function() {'
		    	. '$("#'.$this->id.'_entry").css("display", "none");'
		    	. '$("#'.$this->id.'")'
		    	. '.text($("#'.$this->id.'_entry").val())'
		    	. '.css("display", "");'
		    	. $this->handler
	  		. '});'
	  		. '</script>';
  }
}
