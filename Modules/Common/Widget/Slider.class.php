<?php

class Common_Widget_Slider extends WidgetContainer {
  private $widget;
  private $rotation;
  private $rotationTo;
  private $class;
  private $show;
  private $hide;

  public function __construct($widget) {
    $this->widget = $widget;
  }

  public function SlideRight(){
    $this->rotation = 90;
    $this->rotationTo = 180;
    $this->class = 'right';
    $this->hide = 'slideDown("slow")';
    $this->show = 'slideUp()';
  }

  public function SlideUp(){
    $this->rotation = 90;
    $this->rotationTo = 180;
    $this->class = 'top';
    $this->hide = 'slideDown("slow")';
    $this->show = 'slideUp()';
  }

  public function ToHtml(){
    $this->SlideRight();

    //return $this->widget->ToHtml();
    return '<div id="sliderwrapper_' . $this->widget->id . '" class="' . $this->class . '"> <div id="slider_' . $this->widget->id . '">' . $this->widget->ToHtml() . ' </div><div id="sliderbutton_' . $this->widget->id . '"></div></div>
      <script src="http://code.jquery.com/jquery-latest.js"></script>
      <script>

          $(document).ready(function(){
            $("#sliderbutton_' . $this->widget->id . '").click(function () {
              if ($("#slider_' . $this->widget->id . '").is(":hidden")) {
                $("#slider_' . $this->widget->id . '").' . $this->hide . ';
                $("#sliderbutton_' . $this->widget->id . '").removeClass("rotate");
              } else {
                $("#slider_' . $this->widget->id . '").' . $this->show . ';
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
            -webkit-transform: rotate(' . $this->rotationTo . 'deg);
          }
          #sliderwrapper_' . $this->widget->id . '{
            padding:5px;
            text-align:center;
            border:solid 5px black;
          }
          .right{
            position:fixed;
            margin-top:none;
            margin-left:auto;
            margin-right:none;
            -webkit-transform: rotate(90deg);
           }
          .top{
            margin-left:auto;
            margin-right:auto;
          }
      </style>';
  }
}