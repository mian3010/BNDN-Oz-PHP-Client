<?php

class Widget_Slider extends Widget_Wrapper {
  private $class; // Rotation class
  private $btnClass; // Rotation class
  private $aniAtrb; // Height or width?

  public function __construct() {
    $this->SlideUp();
    $this->classes[] = 'clearfix';
    $this->classes[] = 'slider';
    $this->classes[] = 'inline';
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

  public function GetCss() {
    $css = <<<CSS
      .slider{
        border:solid 1px black;
        border-radius:5px;
        position:relative;

      }
      .sliderwrapper{
        overflow: hidden;
      }
      .sliderbutton{
        width: 0;
        height: 0;
        position: absolute;
      }
      .right{
        margin-left:auto;
        margin-right:0;
       }
       .left{
        margin-left:0;
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
      .rightBtn.rotate {
        left: -8px;
        border-right: 8px solid black;
        border-bottom: 8px solid transparent;
        border-top: 8px solid transparent;
        border-left: 0px solid transparent;
      }
      .leftBtn.rotate {
        right: -8px;
        border-left: 8px solid black;
        border-bottom: 8px solid transparent;
        border-top: 8px solid transparent;
        border-right: 0px solid transparent;
      }
      .topBtn.rotate {
        margin-top: 0px;
        border-left: 8px solid transparent;
        border-top: 8px solid black;
        border-right: 8px solid transparent;
        border-bottom: 0px solid transparent;
      }
      .bottomBtn.rotate {
        margin-top: 0px;
        border-left: 8px solid transparent;
        border-bottom: 8px solid black;
        border-right: 8px solid transparent;
        border-top: 0px solid transparent;
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
CSS;
    $this->AddCss($css);
    return parent::GetCss();
  }

  public function GetJs() {
    $js = <<<JAVASCRIPT
      $(window).load(function() {
        $(".sliderbutton").click(function () {
        var ani = $(this).parent().attr("data-ani"); /* Animate width or height? */
          if($(this).parent()[ani]() == 0) { /* slide out */
            $(this).parent().find(".sliderwrapper").css("visibility", "visible");
            $(this).parent().css(ani, "auto"); /* Set to auto to find auto size */
            var options = {};
            var h = $(this).parent()[ani](); /* Auto size value */
            options[ani] = h; /* [ani] => [h] */
            $(this).parent().css(ani, "0"); /* Set size = = before animation */
            $(this).parent().animate(options, 500, function(){ /* Animate */
              $(this).find(".sliderbutton").removeClass("rotate"); /* Slider button not rotated */
              $(this).parent().find(".sliderwrapper").css(ani, "auto"); /* Set to auto for flexibility */
            });
          } else { /* slide in */
            var options = {};
            options[ani] = 0; /* [ani] => 0 */
            var current = $(this).parent().find(".sliderwrapper")[ani](); /* Get inner wrapper size before animation */
            $(this).parent().find(".sliderwrapper").css(ani, current); /* Set inner wrapper size before animation */
            $(this).parent().animate(options, 500, function(){ /* Animate */
              $(this).find(".sliderbutton").addClass("rotate"); /* Rotate arrow */
              $(this).parent().find(".sliderwrapper").css("visibility", "hidden"); /* Hide content */
            });
          }
        });
      });
JAVASCRIPT;
    $this->AddJs($js);
    return parent::GetJs();
  }

  public function ToHtml(){
    $this->classes[] = $this->class;

    $wrapper = new Widget_Wrapper();
    $wrapper->classes[] = 'sliderwrapper';
    $wrapper->widgets = $this->widgets;
    $this->widgets = array($wrapper);

    $btn = new Widget_Wrapper();
    $btn->id = 'sliderbutton_' . $this->id;
    $btn->classes[] = $this->btnClass;
    $btn->classes[] = 'sliderbutton';

    $this->{'data-ani'} = $this->aniAtrb;
    $this->widgets[] = $btn;

    return parent::ToHtml();
  }
}
