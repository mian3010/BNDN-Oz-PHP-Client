<?php

class Widget_DropdownAutocomplete extends Widget_Wrapper {

  private $options = array();
  private $multiple = false;
  
  public function __construct() {
  
  	$this->AddJsFile('autocomplete.js');
  }

  // Not supported yet  
  //public function SetIsMultiple($val) {
  //
  //	$this->multiple = $val;
  //}
  
  public function IsMultiple() {
  
  	return $this->multiple;
  }

  public function AddSelectOption($text) {
  
  	$this->options[$text] = $text;
  }
  
  public function GetSelectOptions() {
  
  	return array_values($this->options);
  }

  public function ToHtml() {
    
    $html = '<select class="autocomplete" ' . ($this->multiple ? ' multiple' : '') . ' id="' . $this->id . '">';
    
    foreach($this->GetSelectOptions() as $text) $html .= '<option value="' . $text . '">' . $text . '</option>';
    
    $html .= '</select>';
    
    $html .= '<script type="text/javascript">makeAutocomplete($(\'#' . $this->id . '\').first());</script>';
    
    return $html;
  }
}
