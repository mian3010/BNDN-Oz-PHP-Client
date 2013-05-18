<?php
/**
 * Widget for viewing an accounts thumbnail
 */
class Account_Widget_ViewThumbnail extends Widget_Image {
  public function __construct($id) {
    //Use standard image, as backend does not support account pictures
    parent::__construct('static/img/accountThumb.jpg');
    $this->width = 100;
    $this->height = 100;
  }
}
