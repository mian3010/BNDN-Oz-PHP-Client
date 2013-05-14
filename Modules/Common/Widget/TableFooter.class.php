<?php

class Widget_TableFooter extends Widget_Container {
    
  private $foot = null;
  
  public function AddRow($row) {
    $this->foot = $row;
  }
  
  public function ToHtml() {
    if($foot != null) {
      return '<tfoot ' . $this->GetAttributes() . '>' . $this->foot->ToHtml() . '</tfoot>';
    } else {
      return "";
    }
  }
}