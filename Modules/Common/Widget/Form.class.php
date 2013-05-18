<?php
/**
 * Widget for displaying a form
 */
class Widget_Form extends WidgetContainer {
  public function ToHtml() {
    return '<form '.$this->GetAttributes().'>'.$this->ChildrenToHtml().'</form>';
  }
}
