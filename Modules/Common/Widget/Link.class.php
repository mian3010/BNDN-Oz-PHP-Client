<?php

class Widget_Link extends WidgetContainer {
  public function __construct($href) {
    $this->href = $href;
  }

  public function ToHtml() {
    return '<a ' . $this->GetAttributes() . '>' . $this->ChildrenToHtml() . '</a>';
  }
}
