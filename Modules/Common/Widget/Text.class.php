<?php
/**
 * Widget containing a number of paragraphs
 */
class Widget_Text extends Widget_Wrapper {
  private $text;
  public $limit;
  public function __construct($text) {
    $this->text = $text;
    $this->limit = 0;
  }

  public function ToHtml() {
    $text = $this->text;
    //Limit text
    if ($this->limit > 0) $text = substr($text, 0, $this->limit);

    //Convert text line-breaks to paragraph tags
    $texts = preg_split('/(\r?\n)+/', $text);
    $this->widgets = array();
    foreach ($texts as $text) {
      $curr = new Widget_Paragraph($text);
      $this->widgets[] = $curr;
    }

    return parent::ToHtml();
  }
}
