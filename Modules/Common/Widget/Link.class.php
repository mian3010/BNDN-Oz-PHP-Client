<?php

class Widget_Link extends WidgetContainer {
  public function __construct($href) {
    $this->href = $href;
  }

  public function ToHtml() {
  	$js = <<<JS
      $(function () {
    	$('#$this->id').on("click", function (e) {
        	if($this->disable) {
        		e.preventDefault();
        	}
    	});
	});
	
JS;
	$this->AddJs($js);
	
    return '<a ' . $this->GetAttributes() . '>' . $this->ChildrenToHtml() . '</a>';
  }
}
