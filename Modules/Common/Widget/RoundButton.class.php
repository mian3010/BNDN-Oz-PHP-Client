<?php

class Widget_RoundButton extends Widget_Link {
  private $text;

  public function __construct($link, $text) {
    parent::__construct($link);
    $this->text = $text;
  }

  public function GetCss() {
    $css = <<<CSS
      .round-button {
        border-radius: 10px;
        padding: 5px;
        border: 1px solid #ccc;
      }
CSS;
    $this->AddCss($css);

    return parent::GetCss();
  }

  public function ToHtml() {
    $this->classes[] = 'round-button';
    $t = new Widget_TextSimple($this->text);
    $this->widgets[] = $t;
    return parent::ToHtml();
  }
}
