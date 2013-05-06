<?php

class Common_Widget_Button extends Widget {
  private $text;

  public function __construct($text = '') {
    $this->text = $text;
  }

  public function ToHtml() {
    return '<button ' . $this->GetAttributes() . '>' . $this->text . '</button>';
  }
}