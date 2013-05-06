<?php

class Common_Widget_Button extends Widget {
  public $atrbs = array();

  public function __construct($text = '') {
    $this->text = $text;
  }

  public function ToHtml() {
    $atrb = '';
    foreach ($this->atrbs as $key => $value) $atrb .= $key . '="' . $value . '" ';

    return '<button ' . $atrb . '>' . $this->text . '</button>';
  }
}