<?php
/*
 * Widget containing a label with text
 */
class Widget_Label extends Widget {
  private $text;

  public function __construct($text = '') {
    $this->text = $text;
  }

  public function ToHtml() {
    return '<label ' . $this->GetAttributes() . '>' . $this->text . '</label>';
  }
}
