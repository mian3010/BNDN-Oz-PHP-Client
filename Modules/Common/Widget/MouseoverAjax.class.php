<?php

class Common_Widget_MouseOverAjax extends WidgetContainer {
  public function __construct($widget) {
    $this->widget = $widget;
  }

  public function ToHtml() {
    // Debug
    $this->widget = new Common_Widget_Button('____\\\o/_______/\\\____');
    $this->style = 'height:200px; width:200px; border:1px solid black;';

    return
      '<div ' . $this->GetAttributes() . ' >
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
        </script>
        <script>
        $(document).ready(function(){
          $("#' . $this->id . '").mouseover(function() {
             $(this).html(\'' . str_replace("'", "\\'", $this->widget->ToHtml()) . '\');
          });
        });
        </script>
    </div>';
  }
}