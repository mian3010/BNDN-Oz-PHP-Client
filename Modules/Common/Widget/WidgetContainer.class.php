<?php

abstract class WidgetContainer extends Widget {
  public $widgets = array(); // Array of Widgets

  public function GetJs() {
    return $this->getRecursive("GetJs");
  }

  public function GetCss() {
    return $this->getRecursive("GetCss");
  }
  
  public function GetJsFiles() {
    return $this->getRecursive("GetJsFiles");
  }

  public function GetCssFiles() {
    return $this->getRecursive("GetCssFiles");
  }

  private function getRecursive($function) {
    $res = array();
    foreach ($this->widgets as $widget) {
      $res = array_merge($res, call_user_func_array(array($this, $function)));
    }
    return $res;
  }

  protected function ChildrenToHtml() {
    $markup = '';
    foreach ($this->widgets as $widget) $markup .= $widget->ToHtml();
    return $markup;
  }
}
