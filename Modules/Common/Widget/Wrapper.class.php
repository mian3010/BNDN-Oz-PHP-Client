<?php

class Widget_Wrapper extends WidgetContainer {
  public $wrapperTitle;

  public function ToHtml() {
    if(trim($this->wrapperTitle) != '')
      $t = '<h2 class="wrapperTitle">' . $this->wrapperTitle . '</h2>';
    else
      $t = '';

    return '<div ' . $this->GetAttributes() . '">' . $t . $this->ChildrenToHtml().'</div>';
  }
}
