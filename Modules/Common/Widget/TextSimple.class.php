<?php

class Widget_TextSimple extends Widget {
  private $text;

  public function __construct($text = '') {
    $this->text = $text;
  }

  public function ToHtml() {
    return $this->text;
  }
}
