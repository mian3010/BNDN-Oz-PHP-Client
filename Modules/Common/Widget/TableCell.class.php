<?php
/**
 * Widget containing a single table cell
 */
class Widget_TableCell extends Widget_Container {
  
  private $content = null;
  
  public function __construct($content) {
    $this->content = $content; 
  }
  
  public function ToHtml() {
    return '<td ' . $this->GetAttributes() . '>' . $this->content . '</td>';
  }
}
