<?php

class Account_Widget_ViewThumbnail extends Widget_Image {
  public function __construct($id) {
    parent::__construct('static/img/accountThumb.jpg');
    $this->width = 100;
    $this->height = 100;
  }
}