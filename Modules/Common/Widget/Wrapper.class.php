<?php

class Widget_Wrapper extends WidgetContainer {
  public function ToHtml() {
    if(trim($this->GetTitle()) != '')
      $t = '<h2 class="title">' . $this->GetTitle() . '</h2>';
    else
      $t = '';

    return '<div ' . $this->GetAttributes() . '">'.$this->ChildrenToHtml().'</div>';
  }
}
