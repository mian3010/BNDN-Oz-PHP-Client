<?php

class Widget_ThreePartButton extends Widget_Link {
  private $part1;
  private $part2;
  private $part3;

  public function __construct($link, $part1, $part2, $part3) {
    parent::__construct($link);
    $this->part1 = $part1;
    $this->part2 = $part2;
    $this->part3 = $part3;
  }

  public function GetCss() {
    $css = <<<CSS
      .three-part-button div {
        display: inline-block;
        padding: 5px;
        border: 1px solid #ccc;
      }
      .three-part-button div:first-child {
        border-radius: 10px 0 0 10px;
        border-right: 0;
      } 
      .three-part-button div:last-child {
        border-radius: 0 10px 10px 0;
        border-left: 0;
      }

CSS;
    $this->AddCss($css);

    return parent::GetCss();
  }

  public function ToHtml() {
    $this->classes[] = 'three-part-button';
    $p1 = new Widget_Wrapper();
    $p1t = new Widget_TextSimple($this->part1);
    $p1->widgets[] = $p1t;
    $p2 = new Widget_Wrapper();
    $p2t = new Widget_TextSimple($this->part2);
    $p2->widgets[] = $p2t;
    $p3 = new Widget_Wrapper();
    $p3t = new Widget_TextSimple($this->part3);
    $p3->widgets[] = $p3t;
    $this->widgets = array($p1, $p2, $p3);
    return parent::ToHtml();
  }
}
