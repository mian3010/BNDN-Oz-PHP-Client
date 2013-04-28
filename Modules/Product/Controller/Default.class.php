<?php

class Product_Controller_Default extends CommonController {
  public function GetProduct($id) {
    throw new NotImplemtedException();
  }

  /*
   * Get a list of products
   * @param $searchString 
   * @param $type Array of product types
   * @param $unpublished Boolean show unpublished
   * @param $info Level of detail
   * @return Array of Products
   */
  public function GetProducts($searchString, $type, $info, $unpublished) {
    throw new NotImplemtedException();
  }

  public function UpdateProduct($product) {
    throw new NotImplemtedException();
  }

  /*
   * Get product media as a stream
   * @param $id Product id
   * @return Stream
   */
  public function GetProductStream($id) {
    throw new NotImplementedException();
  }

  public function GetProductTypes() {
    throw new NotImplementedException();
  }

  public function GetThumbnail($id) {
    throw new NotImplemtedException();
  }

  public function GetMedia($id) {
    throw new NotImplementedException();
  }

  public function Rate($id, $rating) {
    throw new NotImplementedException();
  }

  /*
   * @param $id Product id
   * @param $file File
   */
  public function UploadThumbnail($id, $file) {
    throw new NotImplementedException();
  }

  /*
   * @param $id Product id
   * @param $file File
   */
  public function UploadMedia($id, $file) {
    throw new NotImplementedException();
  }
}
