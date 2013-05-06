<?php

class Widget_Container extends WidgetContainer {
  public function ToHtml() {
    return $this->ChildrenToHtml();
  }
}
