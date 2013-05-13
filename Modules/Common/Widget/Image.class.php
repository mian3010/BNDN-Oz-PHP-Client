<?php

class Widget_Image extends Widget {
  private $type;
  private $imgHeight;
  private $imgWidth;
  private $imgSrc;
  public function __construct($src) {
    $this->imgSrc = $src;
    list($this->imgWidth, $this->imgHeight, $this->type) = getimagesize($this->imgSrc);
    $this->width = $this->imgWidth;
    $this->height = $this->imgHeight;
  }

  /**
   * Resize the img defined in src using the width and height set.
   */
  private function resizeImage() {
    if (!file_exists('cache')) mkdir('cache');
    $gdImg = $this->getImgAsGd();
    //This could return false if imagetype was not supported
    if ($gdImg == false) throw new ImageException("Image type not supported!");
    //Get the dimensions of the temp image
    list($rw, $rh) = $this->getImgSize();
    //Scale the image according to temp dimensions
    $gdResTmp = imagecreatetruecolor($rw, $rh);
    imagecopyresampled($gdResTmp,$gdImg, 0, 0, 0, 0, $rw, $rh, $this->imgWidth, $this->imgHeight);
    //Set start position for copying image over
    $x0 = ($rw - $this->width) / 2;
    $y0 = ($rh - $this->height) / 2;
    //Copy image to end result
    $gdRes = imagecreatetruecolor($this->width, $this->height);
    imagecopy($gdRes, $gdResTmp, 0, 0, $x0, $y0, $this->width, $this->height);
    //Save the image
    $this->saveImg($gdRes);
    //Cleanup
    imagedestroy($gdImg);
    imagedestroy($gdResTmp);
    imagedestroy($gdRes);
  }

  /**
   * Return the img defined in src as a gd resource
   */
  private function getImgAsGd() {
    switch ($this->type) {
      case IMAGETYPE_GIF:
        return imagecreatefromgif($this->imgSrc);
      case IMAGETYPE_JPEG:
        return imagecreatefromjpeg($this->imgSrc);
      case IMAGETYPE_PNG:
        return imagecreatefrompng($this->imgSrc);
    }
  }

  /**
   * Save a gd resource to a file on filesystem
   */
  private function saveImg($gdImg) {
    switch ($this->type) {
      case IMAGETYPE_GIF:
        return imagegif($gdImg, $this->getResFilename());
      case IMAGETYPE_JPEG:
        return imagejpeg($gdImg, $this->getResFilename(), 90);
      case IMAGETYPE_PNG:
        return imagepng($gdImg, $this->getResFilename(), 9);
    }
  }

  /**
   * Get the image size of the temporary resized image
   */
  private function getImgSize() {
    //Calculate aspect rations
    $sr = $this->imgWidth / $this->imgHeight;
    $rr = $this->width / $this->height;
    //If the aspect of the source is larger, we should calculate width
    if ($sr > $rr) {
      $rh = $this->height;
      $rw = (int)($this->height * $sr);
    //Else we should calculate height
    } else {
      $rw = $this->width;
      $rh = (int)($this->width / $sr);
    }
    return array($rw, $rh);
  }

  /**
   * Get the filename of the resized image
   */
  public function getResFilename() {
    $name = str_replace(array('/', ':'), '_', $this->imgSrc);
    return "cache/{$name}_{$this->width}x{$this->height}".image_type_to_extension($this->type);
  }

  public function ToHtml() {
    if (!file_exists($this->getResFilename())) $this->resizeImage();
    $this->src = $this->getResFilename();
    return '<img '.$this->GetAttributes().' />';
  }
}
