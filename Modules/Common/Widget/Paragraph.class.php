<?php

class Widget_Paragraph extends Widget_Wrapper {
  private $text;
  public function __construct($text) {
    $this->text = $text;
  }

  public function ToHtml() {
    return '<p '.$this->GetAttributes.'>'.$this->text.'</p>';
  }
}
