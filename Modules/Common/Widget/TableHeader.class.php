<?php

class Widget_TableHeader extends Widget_Container {
  
  private $head = null;
  
  public function AddRow($row) {
    $this->head = $row;
  }
  
  public function ToHtml() {
    if($this->head != null) {
      return '<thead ' . $this->GetAttributes() . '>' . $this->head->ToHtml() . '</thead>';
    } else {
      return "";
    }
  }
}