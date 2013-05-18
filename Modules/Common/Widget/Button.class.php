<?php
/**
 * Widget for displaying a button
 */
class Widget_Button extends Widget_InputField {
  private $text;

  public function __construct($text = '') {
    $this->value = $text;
  }

  public function ToHtml() {
    $this->type = "submit";
    return parent::ToHtml();
  }
}
