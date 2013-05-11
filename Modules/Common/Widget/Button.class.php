<?php

class Widget_Button extends Widget {
  private $text;

  public function __construct($text = '') {
    $this->value = $text;
  }

  public function ToHtml() {
    $this->type = "submit";
    return '<input ' . $this->GetAttributes() . '/>';
  }
}
