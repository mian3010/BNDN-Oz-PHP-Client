<?php

class Common_Widget_NavigationOption extends Widget {

  private $options;

  public function __construct($options) {
  
  	$this->options = $options;
  }

  public function ToHtml() {
  
    $result = '<select class="navigation-option" onchange="location.href = this.options[this.selectedIndex].value">';
    
    foreach($this->options as $text => $url) $result .= '<option value="' . $url . '">' . $text . '</option>';
    
    return $result . '</select>';
  }
}