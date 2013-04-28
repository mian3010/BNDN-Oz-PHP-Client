<?php

class Product_Model_Default extends CommonModel {

  /*
   * @param $searchString
   * @param $types Array of product types
   * @param $unpublished Boolean include unpublished
   * @param $info Level of detail
   * @return Array of Products
   */
  public function GetProducts($searchString, $types, $unpublished, $info, $token = null) {
    throw new NotImplementedException();
  }

  /*
   * @param $id
   * @return Product
   */
  public function GetProduct($id, $token = null) {
    throw new NotImplementedException();
  }

  /*
   * Get list of Product types
   * @return array of strings
   */
  public function GetProductTypes() {
    throw new NotImplementedException();
  }
 
  public function CreateProduct($product, $token) {
    throw new NotImplementedException();
  }

  public function UpdateProduct($product, $token) {
    throw new NotImplementedException();
  }

  public function UploadMedia($id, $file, $token) {
    throw new NotImplementedException();
  }

  public function UploadThumbnail($id, $file, $token) {
    throw new NotImplementedException();
  }

  public function GetThumbnail($id, $token = null) {
    throw new NotImplementedException();
  }

  public function GetMedia($id, $token) {
    throw new NotImplementedException();
  }

  public function UpdateRating($id, $rating, $token) {
    throw new NotImplementedException();
  }

  public function GetProductsByAccount($token) {
    throw new NotImplementedException();
  }
}
