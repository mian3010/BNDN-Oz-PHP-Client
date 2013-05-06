<?php

class Common_Widget_MouseOverAjax extends WidgetContainer {
  public $atrbs = array();

  public function __construct($widget) {
    $this->widget = $widget;
  }

  public function ToHtml() {
    $this->widget = new Common_Widget_Button('____\\\o/_______/\\\____');
    $this->atrbs['id'] = 'hej';
    $this->atrbs['style'] = 'height:200px; width:200px; border:1px solid black;';

    $atrb = '';
    foreach ($this->atrbs as $key => $value) $atrb .= $key . '="' . $value . '" ';
    return
      '<div ' . $atrb . ' >
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
        </script>
        <script>
        $(document).ready(function(){
          $("#hej").mouseover(function() {
             $(this).html(\'' . str_replace("'", "\\'", $this->widget->ToHtml()) . '\');
          });
        });
        </script>
    </div>';
  }
}