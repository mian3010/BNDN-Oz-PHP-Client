<?php

class Common_Widget_Label extends Widget {
  public $atrbs = array();

  public function __construct($text = '') {
    $this->text = $text;
  }

  public function ToHtml() {
    $atrb = '';
    foreach ($this->atrbs as $key => $value) $atrb .= $key . '="' . $value . '" ';

    return '<p ' . $this->atrbs . '>' . $this->text . '</p>';
  }
}