<?php
/**
 * Widget containing a link with possibility to disable it
 */
class Widget_Link extends WidgetContainer {
  public function __construct($href) {
    $this->href = $href;
  }

  public function ToHtml() {
  	$js = <<<JS
      $(function () {
    	  $('#$this->id').on("click", function (e) {
        	e.preventDefault();
    	  });
	    });
JS;

	  if ($this->disabled == TRUE) $this->AddJs($js);
	
    return '<a ' . $this->GetAttributes() . '>' . $this->ChildrenToHtml() . '</a>';
  }
}
