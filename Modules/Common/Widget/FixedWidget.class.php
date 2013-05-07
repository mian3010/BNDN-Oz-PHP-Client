<?php

class Common_Widget_FixedWidget extends WidgetContainer {
  private $top;
  private $left;
  private $widget;

  public function __construct($widget){
	$this->widget = $widget;
	$this->top = 0;
	$this->left = 0;
  }
  
  public function SetTop($top) {
  	$this->top = $top;
  }
  
  public function SetLeft($left) {
  	$this->left = $left;
  }
  
  public function ToHtml() {
  	return '<div style="position:fixed;top:' . $this->top . ';left:'. $this->left . ';">' . $this->widget->ToHtml() . '</div>';
  }
}