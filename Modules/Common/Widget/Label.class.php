<?php

class Common_Widget_Label extends Widget {
  private $text;

  public function __construct($text = '') {
    $this->text = $text;
  }

  public function ToHtml() {
    return '<p ' . $this->GetAttributes() . $this->GetClasses() . '>' . $this->text . '</p>';
  }
}