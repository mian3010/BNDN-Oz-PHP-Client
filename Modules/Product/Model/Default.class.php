<?php

class Product_Model_Default extends CommonModel {
	
	public function __construct() {
		require_once(dirname(__FILE__).'/../Modules/Common/Model/WebService.class.php');
	}

  /*
   * @param $searchString
   * @param $types Array of product types
   * @param $unpublished Boolean include unpublished
   * @param $info Level of detail
   * @return Array of Products
   */
  public function GetProducts($searchString, $types, $unpublished, $info, $token = null) {
  	$ws = new WebService('GET','products?search='.$searchString.'&type='.$types.'&info='.$info.'unpublished='.$unpublished);
  	if($token!=null) $ws.SetToken($token);
  	$object = $ws.Execute();
  	$code = $ws.GetHttpStatusCode();
  	if($code==200) return $object;
  	else throw $httpStatusCodeToExceptionMap[$code];
  }

  /*
   * @param $id
   * @return Product
   */
  public function GetProduct($id, $token = null) {
    $ws = new WebService('GET','product/'.$id);
    if($token!=null) $ws.SetToken($token);
    $object = $ws.Execute();
    $code = $ws.GetHttpStatusCode();
    ThrowExceptionIfError($code);
    return $object;
  }

  /*
   * Get list of Product types
   * @return array of strings
   */
  public function GetProductTypes() {
    $ws = new WebService('GET','/product/types');
    if($token!=null) $ws.SetToken($token);
    $object = $ws.Execute();
    $code = $ws.GetHttpStatusCode();
    ThrowExceptionIfError($code);
    return $object;
  }
 
  public function CreateProduct($provider, $product, $token) {
    $ws = new WebService('POST', 'accounts/'.$provider.'/products');
    if($token!=null) $ws.SetToken($token);
    $object = $ws.Execute();
    $code = $ws.GetHttpStatusCode();
    ThrowExceptionIfError($code);
    return $object;
  }

  public function UpdateProduct($provider, $product, $token) {
    $ws = new WebSerice('PUT', 'accounts/'.$provider.'/products');
    if($token!=null) $ws.SetToken($token);
    $object = $ws.Execute();
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
