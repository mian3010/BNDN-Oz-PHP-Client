<?php

class Widget_ClickEditField extends Widget {
  public function __construct($value = ''){
    $this->value = $value;
    $this->handler = '';
    $this->setJs();
  }
  
  public function addHandler($handler) {
    $this->handler = $handler;
    $this->setJs();
  }

  private function setJs() {
    $js = ''
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
	  		. '});';
    $this->AddJs($js, "HandlerJs");
  }
  
  public function ToHtml() {
    $label = new Widget_Label($this->value);
    $label->id = $this->id;
    return 	$label->ToHtml().'<input id="' . $this->id . '_entry" style="display:none;"></input>';
  }
}
