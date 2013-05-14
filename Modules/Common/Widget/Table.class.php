<?php

class Widget_Table extends Widget_Container {
  
  private $head = null;
  private $foot = null;
  private $rows = array();
  
  public function AddHeader($header) {
    $this->head = $header;
    
  }
  
  public function AddRow($row) {
    $this->rows [] = $row;
  }
  
  public function AddFooter($footer) {
    $this->foot = $footer;
  }
    
  public function ToHtml() {
    $str = '<table ' . $this->GetAttributes() . '>';
    
    if($this->head != null) { $str .= $this->head->ToHtml(); }
    
    if($this->rows != null) {
      foreach ($this->rows as $row) { $str .= $row->ToHtml(); }
    }
    
    if($this->foot != null) { $str .= $this->foot->ToHtml(); }
    
    $str .= '</table>';
    return $str;
  }
}
