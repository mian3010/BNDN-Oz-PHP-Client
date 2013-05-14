<?php

class Product_Widget_ViewThumbnail extends Widget_Image {
  public function __construct($id) {
    try {
      parent::__construct(WebService::GetAbsolute("/products/".$id."/thumbnail"));
    } catch (ImageException $e) {
      parent::_construct('static/img/accountThumb.jpg');
    }
    $this->width = 100;
    $this->height = 100;
  }
}
