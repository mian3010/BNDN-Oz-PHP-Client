<?php

class Widget_Image extends Widget {
  private $type;
  private $imgHeight;
  private $imgWidth;
  private $imgSrc;
  private $gdImg;
  private $altSrc;
  public function __construct($src, $altSrc = null) {
    $this->imgSrc = $src;
    $this->altSrc = $altSrc;
  }

  private function findImgSize() {
    list($this->imgWidth, $this->imgHeight, $this->type) = @getimagesize($this->imgSrc);
    if ($this->width == NULL) $this->width = $this->imgWidth;
    if ($this->height == NULL) $this->height = $this->imgHeight;
  }

  /**
   * Resize the img defined in src using the width and height set.
   */
  private function resizeImage() {
    if (!file_exists('cache')) mkdir('cache');
    $gdImg = $this->getImgAsGd();
    if ($gdImg == false) throw new ImageException("Image type not supported!");
    //This could return false if imagetype was not supported
    //Get the dimensions of the temp image
    list($rw, $rh) = $this->getImgSize();
    //Scale the image according to temp dimensions
    $gdResTmp = $this->createTransparent($rw, $rh);
    imagealphablending($gdResTmp, false);
    imagecopyresampled($gdResTmp,$gdImg, 0, 0, 0, 0, $rw, $rh, $this->imgWidth, $this->imgHeight);
    imagesavealpha($gdResTmp, true);
    //Set start position for copying image over
    $x0 = ($rw - $this->width) / 2;
    $y0 = ($rh - $this->height) / 2;
    //Copy image to end result
    $gdRes = $this->createTransparent($this->width, $this->height);
    imagealphablending($gdRes, false);
    imagecopy($gdRes, $gdResTmp, 0, 0, $x0, $y0, $this->width, $this->height);
    imagesavealpha($gdRes, true);
    //Save the image
    $this->saveImg($gdRes);
    //Cleanup
    imagedestroy($gdImg);
    imagedestroy($gdResTmp);
    imagedestroy($gdRes);
  }

  private function createTransparent($x, $y) { 
    $imageOut = imagecreatetruecolor($x, $y);
/*    $colourBlack = imagecolorallocate($imageOut, 0, 0, 0);
imagecolortransparent($imageOut, $colourBlack);*/
    return $imageOut;
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
        return imagejpeg($gdImg, $this->getResFilename(), 100);
      case IMAGETYPE_PNG:
        return imagepng($gdImg, $this->getResFilename(), 0);
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
    $this->ext = pathinfo($this->imgSrc, PATHINFO_EXTENSION);
    $name = str_replace(array('/', ':'), '_', $this->imgSrc);
    return "cache/{$name}_{$this->width}x{$this->height}.".$this->ext;
  }

  private function fileExists() {
    return file_exists($_SERVER["DOCUMENT_ROOT"].$this->getResFilename());
  }

  public function ToHtml() {
    if (!$this->fileExists()) {
      $this->findImgSize();
      if ($this->imgWidth == NULL) {
        $this->imgSrc = $this->altSrc;
        if (!$this->fileExists()) {
          $this->findImgSize();
          $this->resizeImage();
        }
      } else $this->resizeImage();
    }
    $this->src = $this->getResFilename();
    return '<img '.$this->GetAttributes().' />';
  }
}
