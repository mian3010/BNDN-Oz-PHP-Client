<?php
/**
 * Widget containing an input field with a type
 */
class Widget_InputField extends Widget {
  public function __construct($type = 'text') {
    $this->type = $type;
  }

  public function ToHtml() {
    return '<input '.$this->GetAttributes().' />';
  }
}
