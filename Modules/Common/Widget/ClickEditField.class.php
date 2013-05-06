<?php

class Common_Widget_ClickEditField extends Widget {
  public function __construct($value = ''){
    $this->value = $value;
	$this->handler = '';
  }
  
  public function ToHtml() {
    return 	'<label id="' . $this->id . '">' . $this->value . '</label>'
			. '<input id="' . $this->id . '_entry" style="display:none;"></input>'
			. '<script src="./../../Includes/jquery-2.js"></script>'
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
	  		. '});'
	  		. '</script>';
  }
}