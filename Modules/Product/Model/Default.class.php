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
  	if($searchString!=null) {
  		$ws = new WebService('GET', 'products?type='.$types.'$info='.$info.'&unpublished='.$unpublished);
  	}
  	else {
  		$ws = new WebService('GET','products?search='.$searchString.'&type='.$types.'&info='.$info.'unpublished='.$unpublished);
  	}
  	if($token!=null) $ws->SetToken($token);
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
    $ws = new WebService('GET','product/'.$id);
    if($token!=null) $ws->SetToken($token);
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }

  /*
   * Get list of Product types
   * @return array of strings
   */
  public function GetProductTypes() {
    $ws = new WebService('GET','/product/types');
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
    $ws = new WebService('POST', 'accounts/'.$provider.'/products');
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
    $ws = new WebSerice('PUT', 'products/'.$product->id);
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
    $ws = new WebService('POST', 'products/'.$id);
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
    $ws = new WebService('POST', 'products/'.$id.'/THUMBNAIL');
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
    $ws = new WebService('GET', 'products/'.$id.'/THUMBNAIL');
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
    
    $fp = fopen('http://rentit.itu.dk/RentIt27/RentItService.svc/products/'.$id,'r',$context);
    return $fp;
  }

  /*
   * 
   * @param int $id
   * @param int $rating
   * @param string $token
   */
  public function UpdateRating($id, $rating, $token) {
    $ws = new WebService('PUT','products/'.$id.'/rating');
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
