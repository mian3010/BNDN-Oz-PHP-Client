<?php
/**
 * Widget for containing any number of other widgets and wrapping them in nothing
 */
class Widget_Container extends WidgetContainer {
  public function ToHtml() {
    return $this->ChildrenToHtml();
  }
}
