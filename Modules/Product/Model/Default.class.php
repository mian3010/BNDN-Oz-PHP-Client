<?php
class Product_Model_Default extends CommonModel {
	
  /*
   * Get products
   * @param $searchString The string to search by
   * @param $types Array of product types
   * @param $unpublished Boolean include unpublished
   * @param $info Level of detail
   * @return Array of Products
   */
  public function GetProducts($token, $searchString = null, $types = null, $unpublished = null, $info = 'detailed') {
  	$ws = new WebService('products', 'GET');
  	$data = array();
  	if($searchString!=null) {
  		$data['search'] = $searchString;
  	}
  	if($types!=null) {
  		$data['type'] = $types;
  	}
  	if($unpublished!=null) {
  		$data['unpublished'] = $unpublished;
    }
    $data['info'] = $info;
  	if($token!=null) $ws->SetToken($token);
  	$ws->SetData($data);
  	$object = $ws->Execute();
  	$code = $ws->GetHttpStatusCode();
  	$this->ThrowExceptionIfError($code);
  	return $object;
  }

  /**
   * Get products by a specific content provider
   * @param $username The username of the content provider
   * @param $searchString The string to search by
   * @param $types Array of product types
   * @param $unpublished Boolean include unpublished
   * @param $info Level of detail
   * @return Array of Products
   */
  public function GetProductsByContentProvider($username, $token, $searchString = null, $types = null, $unpublished = null, $info = 'detailed') {
  	$ws = new WebService('accounts/'.$username.'/products', 'GET');
  	$data = array();
  	if($searchString!=null) {
  		$data['search'] = $searchString;
  	} else $data['search'] = '';
  	if($types!=null) {
  		$data['type'] = $types;
  	} else $data['type'] = '';
    $data['info'] = $info;
  	if($unpublished!=null) {
  		$data['unpublished'] = $unpublished;
    } else $data['unpublished'] = 'false';
  	if($token!=null) $ws->SetToken($token);
  	$ws->SetData($data);
  	$object = $ws->Execute();
  	$code = $ws->GetHttpStatusCode();
  	$this->ThrowExceptionIfError($code);
  	return $object;
  }

  /*
   * Get a single product
   * @param $id The id of the product
   * @param $token Optional token to send along
   * @return Product object
   */
  public function GetProduct($id, $token = null) {
    $ws = new WebService('products/'.$id, 'GET');
    if($token!=null) $ws->SetToken($token);
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }

  /**
   * Get a type from a product id
   * @param $pId The product id
   * @param $token Optional token to send along
   * @return string containing the product type
   */
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
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }
 
  /*
   * Create a product
   * @param $provider The username of the provider to create for
   * @param $product The product to create
   * @param $token Token to send along
   * @return The new product
   */
  public function CreateProduct($provider, $product, $token) {
    $ws = new WebService('accounts/'.$provider.'/products', 'POST');
    $ws->SetToken($token);
    $ws->SetData($product);
    $data = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $data;
  }

  /*
   * Update a product
   * @param $product The product to update
   * @param $token Token to send along
   * @return null
   */
  public function UpdateProduct($product, $token) {
    $ws = new WebService('products/'.$product['id'], 'PUT');
    $ws->SetToken($token);
    $ws->SetData($product);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  /*
   * Upload media for a product
   * @param $id The id of the product
   * @param $file The media to upload
   * @param $token Token to send along
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
   * Upload thumbnail for a product
   * @param $id The id of the product
   * @param $file The file to upload
   * @param $token Token to send along
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
   * Get the thumbnail for a product
   * @param $id The id of the product
   * @param $token Optional thumbnail
   * @return The thumbnail
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
   * Get the media for a product
   * @param $id The id of the product
   * @param $token Token to send along
   * @return The media for the product
   */
  public function GetMedia($id, $token) {
    $opts = array('http' =>array('method' =>'GET','header'=>'token:'.$token));
    $context = stream_context_create($opts);
    $fp = fopen('http://rentit.itu.dk/RentIt27/RentItService.svc/accounts/'.$_SESSION['username'].'/purchases/'.$id.'/media',"r",false, $context);
    return $fp;
  }

  /*
   * Update the rating of a product
   * @param $id The id of the product
   * @param $rating The rating to rate it
   * @param $token Token to send along
   * @return null
   */
  public function UpdateRating($id, $rating, $token) {
    $ws = new WebService('products/'.$id.'/rating', 'PUT');
    $ws->SetToken($token);
    $ratingD = new StdClass();
    $ratingD->rating = $rating;
    $ws->SetData($ratingD);
    $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
  }

  /*
   * Returns the MIME-type of the given file.
   * @param media $file
   * @return string mime
   */
  private function setMime($file) {
  	$finfo = finfo_open(FILEINFO_MIME_TYPE);
  	$mime = finfo_file($finfo, $file);
  	$finfo->close($finfo);
  	return $mime;
  }
}
