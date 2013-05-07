<?php

class Common_Widget_Slider extends WidgetContainer {
  private $widget;

  public function __construct($widget) {
    $this->widget = $widget;
  }

  public function ToHtml(){
    // Create a wrapper and add the widget
    $wrapper = new Common_Widget_Wrapper();
    $wrapper->id = 'slider_' . $this->id;
    $wrapper->widgets[$this->id] = $this->widget;

    // Add slider functionality to the wrapper
    //return $this->widget->ToHtml();
    return '<div id="sliderwrapper_' . $this->widget->id . '"> <div id="slider_' . $this->widget->id . '">' . $this->widget->ToHtml() . ' </div><div id="sliderbutton_' . $this->widget->id . '"></div></div>
      <script src="http://code.jquery.com/jquery-latest.js"></script>
      <script>

          $(document).ready(function(){
            $("#sliderbutton_' . $this->widget->id . '").click(function () {
              if ($("#slider_' . $this->widget->id . '").is(":hidden")) {
                $("#slider_' . $this->widget->id . '").slideDown("slow");
                $("#sliderbutton_' . $this->widget->id . '").removeClass("rotate");
              } else {
                $("#slider_' . $this->widget->id . '").slideUp();
                $("#sliderbutton_' . $this->widget->id . '").addClass("rotate");
              }
            });
          });
      </script>
      <style>
          #slider_' . $this->widget->id . '{
            border:solid 1px black;
            margin:3px;
            padding:3px;
            border-radius:5px;
            text-align:center;
          }
          #sliderbutton_' . $this->widget->id . '{
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid black;
            margin-left:auto;
            margin-right:auto;
            clear:both;
          }
          .rotate{
            -webkit-transform: rotate(180deg);
          }
          #sliderwrapper_' . $this->widget->id . '{
            padding:5px;
            margin-left:auto;
            margin-right:auto;
          }
      </style>';
  }
}