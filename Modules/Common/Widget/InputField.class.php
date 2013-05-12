<?php

class Widget_InputField extends Widget {
  public function __construct($type = 'text') {
    $this->type = $type;
  }

  public function ToHtml() {
    return '<input '.$this->GetAttributes().' />';
  }
}
