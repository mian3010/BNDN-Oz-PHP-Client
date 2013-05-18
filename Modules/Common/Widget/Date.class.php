<?php
/**
 * Widget for displaying a date
 */
class Widget_Date extends Widget {
  private $date;
  private $format;

  public function __construct($date, $format = 'Y-m-d h:i:s') {
    $this->date = $date;
    $this->format = $format;
  }

  public function ToHtml() {
    return '<span ' . $this->GetAttributes() . '>' . date($this->format, strtotime($this->date)) . '</span>';
  }
}
