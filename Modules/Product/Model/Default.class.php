<?php
class Product_Model_Default extends CommonModel {
	
  /*
   * @param $searchString
   * @param $types Array of product types
   * @param $unpublished Boolean include unpublished
   * @param $info Level of detail
   * @return Array of Products
   */
  public function GetProducts($searchString, $types, $unpublished = null, $info = 'more', $token = null) {
  	$ws = new WebService('products', 'GET');
  	$data = array();
  	if($searchString!=null) {
  		$data['search'] = $searchString;
  	}
  	if($types!=null) {
  		$data['types'] = $types;
  	}
  	if($unpublished!=null) {
  		$data['unpublished'] = $unpublished;
  	}
  	if($token!=null) $ws->SetToken($token);
  	$ws->SetData($data);
  	$object = $ws->Execute();
  	$code = $ws->GetHttpStatusCode();
  	$this->ThrowExceptionIfError($code);
  	return $object;
  }

  /*
   * @param $id
   * @return Product
   */
  public function GetProduct($id, $token = null) {
    $ws = new WebService('products/'.$id, 'GET');
    if($token!=null) $ws->SetToken($token);
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }
  
  public function GetProductType($pId, $token = null) {
  	$object = $this->GetProduct($pId, $token);
    return $object->type;
  }

  /*
   * Get list of Product types
   * @return array of strings
   */
  public function GetProductTypes() {
    $ws = new WebService('/products/types', 'GET');
    $ws->SetToken($token);
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }
 
  /*
   * 
   * @param string $provider
   * @param object $product
   * @param string $token
   */
  public function CreateProduct($provider, $product, $token) {
    $ws = new WebService('accounts/'.$provider.'/products', 'POST');
    $ws->SetToken($token);
    $ws->SetData($product);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  /*
   * 
   * @param object $product
   * @param string $token
   */
  public function UpdateProduct($product, $token) {
    $ws = new WebSerice('products/'.$product->id, 'PUT');
    $ws->SetToken($token);
    $ws->SetData($product);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  /*
   * 
   * @param int $id
   * @param media $file
   * @param string $token
   */
  public function UploadMedia($id, $file, $token) {
    $ws = new WebService('products/'.$id, 'POST');
    $ws->SetToken($token);
    $ws->SetData($file);
    $mime = $this->setMime($file);
    $ws->SetContentType($mime);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  /*
   * 
   * @param int $id
   * @param image $file
   * @param string $token
   */
  public function UploadThumbnail($id, $file, $token) {
    $ws = new WebService('products/'.$id.'/THUMBNAIL', 'POST');
    $ws->SetToken($token);
    $ws->SetData($file);
    $mime = $this->setMime($file);
    $ws->SetContentType($mime);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  /*
   * 
   * @param int $id
   * @param string $token
   * @return image
   */
  public function GetThumbnail($id, $token = null) {
    $ws = new WebService('products/'.$id.'/thumbnail', 'GET');
    if($token!=null) $ws->SetToken($token);
    $thumb = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $thumb;
  }

  /*
   * 
   * @param int $id
   * @param string $token
   * @return unknown $media
   */
  public function GetMedia($id, $token) {
    $opts = array('http' =>array('method' =>'GET','header'=>'token:'.$token));
    $context = stream_context_create($opts);
    $fp = fopen('http://rentit.itu.dk/RentIt27/RentItService.svc/accounts/'.$_SESSION['username'].'/purchases/'.$id.'/media',r,false, $context);
    return $fp;
  }

  /*
   * 
   * @param int $id
   * @param int $rating
   * @param string $token
   */
  public function UpdateRating($id, $rating, $token) {
    $ws = new WebService('PUT','products/'.$id.'/rating', 'GET');
    $ws->SetToken($token);
    $ws->SetData($rating);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  public function GetProductsByAccount($token) {
    throw new NotImplementedException();
  }
  
  /*
   * Returns the MIME-type of the given file.
   * @param media $file
   * @return string mime
   */
  private function setMime($file) {
  	$mime;
  	$finfo = finfo_open(FILEINFO_MIME_TYPE);
  	$mime = finfo_file($finfo, $file);
  	$finfo_close($finfo);
  	return $mime;
  }
}
