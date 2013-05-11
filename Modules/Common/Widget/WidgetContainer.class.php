<?php

abstract class WidgetContainer extends Widget {
  public $widgets = array(); // Array of Widgets

  public function GetJs() {
    return array_merge(parent::GetJs(), $this->getRecursive("GetJs"));
  }

  public function GetCss() {
    return array_merge(parent::GetCss(), $this->getRecursive("GetCss"));
  }
  
  public function GetJsFiles() {
    return array_merge(parent::GetJsFiles(), $this->getRecursive("GetJsFiles"));
  }

  public function GetCssFiles() {
    return array_merge(parent::GetCssFiles(), $this->getRecursive("GetCssFiles"));
  }

  private function getRecursive($function) {
    $res = array();
    foreach ($this->widgets as $widget) {
      $res = array_merge($res, call_user_func_array(array($widget, $function), array()));
    }
    return $res;
  }

  protected function ChildrenToHtml() {
    $markup = '';
    foreach ($this->widgets as $widget) $markup .= $widget->ToHtml();
    return $markup;
  }
}
