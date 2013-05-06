<?php

abstract class WidgetContainer extends Widget {
  public $widgets = array(); // Array of Widgets

  protected function ChildrenToHtml() {
    $markup = '';
    foreach ($this->widgets as $widget) $markup .= $widget->ToHtml();
    return $markup;
  }
}
