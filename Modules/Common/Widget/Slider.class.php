<?php

class Common_Widget_Slider extends WidgetContainer {
  private $widget; // Shown within the slider
  private $class; // Rotation class
  private $btnClass; // Rotation class
  private $aniAtrb; // Height or width?

  public function __construct($widget) {
    $this->widget = $widget;
    $this->SlideUp();
  }

  public function SlideRight(){
    $this->class = 'right';
    $this->btnClass = 'rightBtn';
    $this->aniAtrb = 'width';
  }

  public function SlideLeft(){
    $this->class = 'left';
    $this->btnClass = 'leftBtn';
    $this->aniAtrb = 'width';
  }

  public function SlideUp(){
    $this->class = 'top';
    $this->btnClass = 'topBtn';
    $this->aniAtrb = 'height';
  }

  public function SlideDown(){
    $this->class = 'bottom';
    $this->btnClass = 'bottomBtn';
    $this->aniAtrb = 'height';
  }

  public function ToHtml(){
    return '<div id="sliderwrapper_' . $this->widget->id . '" class="' . $this->class . '"> <div id="slider_' . $this->widget->id . '">' . $this->widget->ToHtml() . ' </div><div id="sliderbutton_' . $this->widget->id . '" class="' . $this->btnClass . '"></div></div>
      <script src="http://code.jquery.com/jquery-latest.js"></script>
      <script>

          $(document).ready(function(){
            $("#sliderbutton_' . $this->widget->id . '").click(function () {
              if ($("#sliderwrapper_' . $this->widget->id . '").' . $this->aniAtrb . '() == 0) {
                $("#slider_' . $this->widget->id . '").css("display", "block");
                $("#sliderwrapper_' . $this->widget->id . '").css("' . $this->aniAtrb . '", "auto");
                var h = $("#sliderwrapper_' . $this->widget->id . '").' . $this->aniAtrb . '();
                $("#sliderwrapper_' . $this->widget->id . '").css("' . $this->aniAtrb . '", "0");
                $("#sliderwrapper_' . $this->widget->id . '").animate({ ' . $this->aniAtrb . ':h }, 500, function(){ $("#sliderbutton_' . $this->widget->id . '").removeClass("rotate"); });
              } else {
                $("#sliderwrapper_' . $this->widget->id . '").animate({ ' . $this->aniAtrb . ':0 }, 500, function(){ $("#sliderbutton_' . $this->widget->id . '").addClass("rotate");  $("#slider_' . $this->widget->id . '").css("display", "none"); });
              }
            });
          });
      </script>
      <style>
          #slider_' . $this->widget->id . '{
            border:solid 1px black;
            border-radius:5px;
          }
          #sliderbutton_' . $this->widget->id . '{
            width: 0;
            height: 0;
            position: absolute;
          }
          #sliderwrapper_' . $this->widget->id . '{
            text-align:center;
            position:relative;

          }
          .right{
            margin-left:auto;
            margin-right:none;
           }
           .left{
            margin-left:none;
            margin-right:auto;
           }
          .top{
            margin-left:auto;
            margin-right:auto;
          }
          .bottom{
            margin-left:auto;
            margin-right:auto;
          }
          .rotate{
            -webkit-transform: rotate(180deg);
          }
          .rightBtn.rotate {
            left: -8px;
          }
          .leftBtn.rotate {
            right: -8px;
          }
          .topBtn.rotate {
            margin-top: 0px;
          }
          .bottomBtn.rotate {
            margin-top: 0px;
          }
          .rightBtn{
            border-left: 8px solid black;
            border-bottom: 8px solid transparent;
            border-top: 8px solid transparent;
            left: 0;
            top: 50%;
            margin-top: -8px;
          }
          .leftBtn{
            border-right: 8px solid black;
            border-bottom: 8px solid transparent;
            border-top: 8px solid transparent;
            right: 0px;
            top: 50%;
            margin-top: -8px;
          }
          .topBtn{
            border-left: 8px solid transparent;
            border-bottom: 8px solid black;
            border-right: 8px solid transparent;
            right:50%;
            margin-right:-8px;
            margin-top: -8px;
          }
          .bottomBtn{
            border-left: 8px solid transparent;
            border-top: 8px solid black;
            border-right: 8px solid transparent;
            right:50%;
            margin-right:-8px;
            top:0px;
            margin-top: 0px;
          }
      </style>';
  }
}