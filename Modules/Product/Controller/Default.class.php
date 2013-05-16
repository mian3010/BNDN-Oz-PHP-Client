<?php

class Product_Controller_Default extends CommonController {
	
	/**
	 * 
	 */
	public function __construct() {
		$this->productModel = CommonModel::GetModel('Product');
	}
	
	/**
	 * 
	 * @param string $id
	 * @return Product_Widget_ViewProduct
	 */
  public function View($id = 0) {
    return new Product_Widget_ViewRating();
    if($id == 0){
      RentItError('Product not found');
      RentItGoto('Product', 'ViewTypes');
    }
		try {
			$product = $this->productModel->GetProduct($id, $_SESSION['token']->token);
      if($product == null) {
        RentItError('Product not found');
        RentItGoto('Product', 'ViewTypes');
      }
      $edit = FALSE;
      if((isset($_SESSION['username'])) && strtolower($_SESSION['username']) == $product->owner) $edit = TRUE;
      elseif(isset($_SESSION['type']) && strtolower($_SESSION['type']) == 'admin') $edit = TRUE;
			return new Product_Widget_ViewProduct($product, $edit);
		} catch (ForbiddenException $e) {
			  RentItError('Product not found');
		} catch (NotFoundException $e) {
			  RentItError('Product not found');
		} catch (Exception $e) {
			  RentItError('Server error');
		}
	  RentItGoto('Product', 'ViewTypes');
	}
	
	/**
	 * 
	 * @param string $searchString
	 * @param string $types
	 * @param booleain $unpublished
	 * @param string $info
	 * @return Product_Widget_ViewProducts
	 */
	public function ViewAll() {
		try {
			$info = 'detailed';	
      $products = $this->productModel->getProducts($this->getToken(), null, null, null, 'detailed');
			return new Product_Widget_ViewProducts($products);
		} catch (BadRequestException $e) {
      RentItError('Internal error');
      RentItGoto("Product", "ViewProducts");
    } catch (ForbiddenException $e) {
      //TODO
		} catch (ServerErrorException $e) {
      RentItError('Server error');
      RentItGoto("Product", "");
		}
	}
	
	/**
	 * 
	 * @param string $searchString
	 * @param string $types
	 * @param string $unpublished
	 * @return Product_Widget_ViewProducts
	 */
	public function SearchProducts($searchString = null, $types = null, $unpublished = false) {
		try {
			$info = 'detailed';
			$products = $this->productModel->getProducts($searchString, $types, $unpublished, $info, $this->getToken());
			return new Product_Widget_ViewProducts($products);
		} catch (BadRequestException $e) {
      RentItError('Internal error');
      RentItGoto("Product", "ViewProducts");
		} catch (ForbiddenException $e) {
      //RentItError($message);
      //RentItGoto($module, $method);
		} catch (ServerErrorException $e) {
      RentItError('Server error');
      RentItGoto("Product", "");
		}		
	}
	
	/**
	 * 
	 */
	public function GetProductTypes() {
		return $this->productModel->GetTypes();
  }

  public function ViewTypes() {
    $w = new Widget_Wrapper();
    $pm = $this->productModel;
    $productTypes = $pm->GetProductTypes();
    foreach ($productTypes as $productType) {
      $products = array_slice($pm->GetProducts(null, null, $productType), 0,4);
      $w->widgets[] = new Product_Widget_ViewType($productType, $products);
    }
    return $w;
  }

  public function ViewType($productType) {
    $pm = $this->productModel;
    $products = $pm->GetProducts(null, null, $productType);
    return new Product_Widget_ViewType($productType, $products);
  }
	
	/**
	 * 
	 */
	public function CreateProduct() {
    /*
		if(isset($_POST['submit'])) {
			if(!isset($_POST['title'])) {
				
			} else {
				$product->title = $_POST['title'];
				$product->description = $_POST['description'];
				$product->type = $_POST['type'];
				if(isset($_POST['buyable'])) {
					if($_POST['buyPrice']<0) {
						RentItError('Price must not be negative');
						RentItGoto('Product', 'CreateProduct');
					}
					else {
						$product->buyPrice = $_POST['buyPrice'];
					}
				}
				if(isset($_POST['rentable'])) {
					if($_POST['rentPrice']<0) {
            RentItError('Price must not be negative');
						RentItGoto('Product', 'CreateProduct');
					}
					else {
						$product->rentPrice = $_POST['rentPrice'];
					}
				}
				try {
					$this->productModel->CreateProduct($_SESSION['username'], $product, $this->getToken());
					return null;
				} catch(BadRequestException $e) {
					RentItError('Something went wrong, please try again');	
					RentItGoto('Product', 'CreateProduct');	
				} catch (ForbiddenException $e) {
					RentItError('Login has expired');
					RentItGoto('Auth', 'Login');
				} catch (NotFoundException $e) {
					RentItError('Server error');
					RentItGoto('Product', 'CreateProduct');
				} catch (RequestEntityTooLargeException $e) {
			
				}
			}
		} else {
			if(isset($_SESSION['token'])) {
				$user = $this->getToken();
				if($user->type=='contentProvider') {
					$types = $this->productModel->GetTypes();
					return new Product_Widget_CreateProduct($types);
				}
			}
		}*/
	}
	
	/**
	 * 
	 * @param int $id
	 */
	public function UpdateProduct($id) {
    // Build info array
    $info = array();
    foreach ($_POST as $k => $v){
      if(trim($v) != '' && $k != 'published' && $k != 'buy' && $k != 'rent')
        $info[$k] = strtolower($v);
    }
    $info['id'] = $id;
    if(isset($_POST['published'])) $info['published'] = true;
    else $info['published'] = false;

    $price = new stdClass();
    $price->buy = $_POST['buy'];
    $price->rent = $_POST['rent'];
    $info['price'] = $price;

    try{
      if(isset($_SESSION['token']))
        $this->productModel->UpdateProduct($info, $_SESSION['token']->token);
      else{
        RentItError('Please authenticate');
        RentItGoto("Auth", "Login");
      }
    } catch (UnauthorizedException $e){
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto();
    }
    RentItGoto('Product', 'View/' . $info['id']);
	}
	
	/**
	 * 
	 * @param string $id
	 * @return Product_Widget_UploadMedia
	 */
	public function UploadMedia($id = null) {
		if(isset($_POST['submit'])) {
			
		} else {
			if(isset($_POST['token'])) {
				$user = $this->getToken();
				if($user->type == 'contentProvider') {
					return new Product_Widget_UploadMedia($id);
				}
			}
		}
	}
	
	/**
	 * 
	 * @param string $id
	 */
	public function UploadThumbnail($id = null) {
		if(isset($_POST['submit'])) {
			
		} else {
			
		}
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return StreamProduct
	 */
	public function StreamProduct($tId) {
		if(isset($_SESSION['token'])) {
			$streamURL = UriController::GetAbsolutePath("/Product/GetStreamFileContent/" . $tId);
			
			$pm = CommonModel::GetModel('Purchase');
			$transaction = $pm->GetPurchase($_SESSION['username'], $this->getToken(), $tId);
			$pId = $transaction->product;
			
			$product = $this->productModel->GetProduct($pId, $this->getToken());
			
			return new Product_Widget_StreamProduct($streamURL, $product);
		} else {
			RentItError('Authentication needed');
			RentItGoto('Auth', 'Login');
		}
	}

	public function GetStreamFileContent($id) {
		if(isset($_SESSION['token'])) {
			$pm = CommonModel::GetModel('Purchase');
			$pId = $pm->GetPurchase($_SESSION['username'], $this->getToken(), $id)->product;
			$type = $this->productModel->GetProductType($pId, $this->getToken());
			switch ($type) {
				case 'ebook':
					header("Content-Type: application/pdf");
					break;
			}
				
			$stream = $this->productModel->GetMedia($id, $this->getToken());
			while ($data = fread($stream, 8192)) {
				echo $data;	
			}
			fclose($stream);
		} else {
			RentItError('Authentication needed');
			RentItError('Auth', 'Login');
		}
		exit();
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Product_Widget_ViewRating
	 */
	public function ViewRating($id) {
		if(isset($_POST['rating'])) {
			if(isset($_SESSION['token'])) {
				try{
					$this->productModel->UpdateRating($id, $_POST['rating'], $this->getToken());
				} catch (Exception $e) {
					
				}
			}
		} else {
			$product = $this->productModel->GetProduct($id, $this->getToken);
			$rating = $product->rating;
			return new Product_Widget_ViewRating($rating);
		}
	}
	
	/**
	 * 
	 * @return token|NULL
	 */	
	private function getToken() {
		if(isset($_SESSION['token'])) {
			return $_SESSION['token']->token;
		} else {
			return null;
		}
	}
	
	/**
	 * 
	 * @return object $user
	 */
	private function getUser() {
		if(getToken!=null) {
			$accountModel = CommonModel::GetModel('Account');
			$user = $accountModel->GetAccount($_SESSION['username'], $this->getToken());
			return $user;
		}
  }
}
