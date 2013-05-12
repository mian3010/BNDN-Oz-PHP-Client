<?php

class Widget_Wrapper extends WidgetContainer {
  public function ToHtml() {
    return '<div ' . $this->GetAttributes() . '">'.$this->ChildrenToHtml().'</div>';
  }
}
