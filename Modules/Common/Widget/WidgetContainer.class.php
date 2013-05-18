<?php
/**
 * Base class for all widgets that contain other widgets
 */
abstract class WidgetContainer extends Widget {
  public $widgets = array(); // Array of Widgets

  /**
   * Override base method to return an array containing the js of all the widgets
   * @return Array of js
   */
  public function GetJs() {
    return array_merge(parent::GetJs(), $this->getRecursive("GetJs"));
  }

  /**
   * Override base method to return an array containing the css of all the widgets
   * @return Array of css
   */
  public function GetCss() {
    return array_merge(parent::GetCss(), $this->getRecursive("GetCss"));
  }
  
  /**
   * Override base method to return an array containing the js files of all the widgets
   * @return Array of js files
   */
  public function GetJsFiles() {
    return array_merge(parent::GetJsFiles(), $this->getRecursive("GetJsFiles"));
  }

  /**
   * Override base method to return an array containing the css files of all the widgets
   * @return Array of css files
   */
  public function GetCssFiles() {
    return array_merge(parent::GetCssFiles(), $this->getRecursive("GetCssFiles"));
  }

  /**
   * Get something recursive through all the widgets
   * @param $function The get function to call on all widgets
   * @return The combined array from all widgets
   */
  private function getRecursive($function) {
    $res = array();
    foreach ($this->widgets as $widget) {
      $res = array_merge($res, call_user_func_array(array($widget, $function), array()));
    }
    return $res;
  }

  /**
   * Get the HTML of all child widgets
   * @return HTML of all child widgets
   */
  protected function ChildrenToHtml() {
    $markup = '';
    foreach ($this->widgets as $widget) $markup .= $widget->ToHtml();
    return $markup;
  }
}
