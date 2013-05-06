<?php

class Widget_Wrapper extends WidgetContainer {
  public function ToHtml() {
    return '<div id="'.$this->id.'" class="'.$this->GetClasses().'">'.$this->ChildrenToHtml().'</div>';
  }
}
