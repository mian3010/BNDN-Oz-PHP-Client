<?php

abstract class WidgetContainer extends Widget {
  public $widgets; // Array of Widgets

  protected function ChildrenToHtml() {
    $markup = '';
    foreach ($widgets as $widget) $markup .= $widget->ToHtml();
    return $markup;
  }
}
