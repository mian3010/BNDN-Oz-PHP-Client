<?php

class Widget_CheckBox extends Widget {

  public function __construct($checked = FALSE){
    if($checked) $this->checked = '';
  }

  public function ToHtml(){
    $this->type = "checkbox";
    return '<input ' . $this->GetAttributes() . '></input>';
  }
}