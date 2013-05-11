<?php

class Widget_TextField extends Widget {
  public function __construct($label = ''){
    $this->label = $label;
    $this->default = '';
  }
  public function ToHtml() {
    $returnVal = '';
    if($this->label != '') { $returnVal = '<label for="' . $this->id . '">' . $this->label . ': </label>'; }
    return $returnVal . ' <input type="text" name="tf_' . $this->id . '" id="' . $this->id . '" value="' . $this->default . '"/>';
  }
}