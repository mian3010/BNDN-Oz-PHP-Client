<?php

abstract class WidgetContainer extends Widget {
  public $widgets = array(); // Array of Widgets

  public function GetJs() {
    return $this->ArrayToString($this->getRecursive("GetJs"));
  }

  public function GetCss() {
    return $this->ArrayToString($this->getRecursive("GetCss"));
  }
  
  public function GetJsFiles() {
    return $this->ArrayToString($this->getRecursive("GetJsFiles"));
  }

  public function GetCssFiles() {
    return $this->ArrayToString($this->getRecursive("GetCssFiles"));
  }

  private function getRecursive($function) {
    $res = array();
    foreach ($widgets as $widget) {
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
