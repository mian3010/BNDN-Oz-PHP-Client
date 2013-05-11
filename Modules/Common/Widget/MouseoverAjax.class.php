<?php

class Widget_MouseOverAjax extends WidgetContainer {
  private $widget;

  public function __construct($widget, $id) {
    $this->widget = $widget;
    $this->id = $id;
    $this->style = 'height:200px; width:200px; border:1px solid black;';
  }

  public function ToHtml() {
    // Debug
    $this->widget = new Common_Widget_Button('____\\\o/_______/\\\____');
    $this->widget->id = "ert";

    return
      '<div ' . $this->GetAttributes() . $this->GetClasses() . ' >
      <style>
        #' . $this->widget->id . ' {
          position: fixed;
        }
      </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
        </script>
        <script>
        $(document).ready(function(){
          $("#' . $this->id . '").mouseover(function() {
            if (!$("#hover_' . $this->id . '").length)
              $(this).after(\'<div id="hover_' . $this->id . '">' . str_replace("'", "\\'", $this->widget->ToHtml()) . '</div>\');
          });
        });
        $("#' . $this->id . '").mousemove(function(e) {
          $(\'#' . $this->widget->id . '\').css(\'display\', "block");
          $(\'#' . $this->widget->id . '\').css(\'left\', e.offsetX+20);
          $(\'#' . $this->widget->id . '\').css(\'top\', e.offsetY+20);
        });
        $("#' . $this->id . '").mouseout(function(e) {
          $(\'#' . $this->widget->id . '\').css(\'display\', \'none\');
        });
        </script>
    </div>';
  }
}