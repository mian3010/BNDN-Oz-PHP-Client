<?php

class Common_Widget_Button extends Widget {
  public function __construct($value = '') {
    $this->value = $value;
    $this->type = '';
    $this->disabled = '';
    $this->formmethod = '';
    $this->formaction = '';
    $this->form = '';
    $this->name = '';
  }

  public function ToHtml() {
    if ($this->type != '') { $this->type = ' type="' . $this->type . '" '; }
    if ($this->formmethod != '') { $this->formmethod = ' formmethod="' . $this->formmethod . '" '; }
    if ($this->formaction != '') { $this->formaction = ' formaction="' . $this->formaction . '" '; }
    if ($this->form != '') { $this->form = ' form="' . $this->form . '" '; }
    if ($this->name != '') { $this->name = ' name="' . $this->name . '" '; }
    return '<button id="' . $this->id .'"' . $this->name . $this->type . $this->disabled . $this->form . $this->formmethod . $this->formaction . '>' . $this->value . '</button>';
  }
}