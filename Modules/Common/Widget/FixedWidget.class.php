<?php
/**
 * Widget for displaying a wrapper fixed on the page
 */
class Widget_FixedWidget extends Widget_Wrapper {
  private $top;
  private $left;

  public function __construct(){
    $this->top = 0;
    $this->left = 0;
  }
  
  public function GetCss() {
    $css = <<<CSS
      .fixed-wrapper {
        position: fixed;
      }
CSS;
    $this->AddCss($css);
    return parent::GetCss();
  }
  
  public function ToHtml() {
    $this->style="top:{$this->top};left:{$this->left};";
    $this->classes[] = 'fixed-wrapper';
  	return parent::ToHtml();
  }
}
