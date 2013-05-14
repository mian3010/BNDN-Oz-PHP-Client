<?php

class Widget_TableRow extends Widget_Container {
  
  private $cells = array();
  
  public function AddCell($cell) {
    $this->cells [] = $cell;
  }
  
  public function AutoCreateCell($str) {
    $this->AddCell(new Widget_TableCell($str));
  }
  
  /**
   * Automaticly creates multiple cells with the given string as content by comma seperating
   */
  public function AutoCreateMultiCells($str) {
    $a = explode(",", $str);
    foreach ($a as $con) {
      $this->AddCell(new Widget_TableCell($con));
    }
  }
  
  public function ToHtml() {
    $str = '<tr ' . $this->GetAttributes() . '>';
    foreach ($this->cells as $cell) {
      $str .= $cell->ToHtml();
    }
    $str .= '</tr>';
    return $str;
  }
}