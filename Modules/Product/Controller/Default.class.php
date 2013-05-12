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
	public function View($id = null) {
		try {
			$product = $this->productModel->GetProduct($id, $this->getToken());
			return new Product_Widget_ViewProduct($product);
		} catch (ForbiddenException $e) {
			RentItError('Product', '', 'Product not found');
		} catch (NotFoundException $e) {
			RentItError('Product', '', 'Product not found');
		} catch (Exception $e) {
			RentItError('Product', '', 'Server error');
		}
	}
	
	/**
	 * 
	 * @param string $searchString
	 * @param string $types
	 * @param booleain $unpublished
	 * @param string $info
	 * @return Product_Widget_ViewProductList
	 */
	public function ViewProductList($searchString = null, $types = null, $unpublished = false) {
		try {
			$info = 'detailed';	
			$products = $this->productModel->getProducts($searchString, $types, $unpublished, $info, $this->getToken());
			return new Product_Widget_ViewProductList($products);
		} catch (BadRequestException $e) {
			RentItError('Product', 'ViewProducts', 'Internal error');
		} catch (ForbiddenException $e) {
			RentItError($module, $method, $message);
		} catch (ServerErrorException $e) {
			RentItError('Product', '', 'Server error');
		}
	}
	
	/**
	 * 
	 * @param string $searchString
	 * @param string $types
	 * @param string $unpublished
	 * @return Product_Widget_ViewProductList
	 */
	public function SearchProducts($searchString = null, $types = null, $unpublished = false) {
		try {
			$info = 'detailed';
			$products = $this->productModel->getProducts($searchString, $types, $unpublished, $info, $this->getToken());
			return new Product_Widget_ViewProductList($products);
		} catch (BadRequestException $e) {
			RentItError('Product', 'ViewProducts', 'Internal error');
		} catch (ForbiddenException $e) {
			RentItError($module, $method, $message);
		} catch (ServerErrorException $e) {
			RentItError('Product', '', 'Server error');
		}		
	}
	
	/**
	 * 
	 */
	public function GetProductTypes() {
		return $this->productModel->GetTypes();
	}
	
	/**
	 * 
	 */
	public function CreateProduct() {
		if(isset($_POST['submit'])) {
			if(!isset($_POST['title'])) {
				
			} else {
				$product->title = $_POST['title'];
				$product->description = $_POST['description'];
				$product->type = $_POST['type'];
				if(isset($_POST['buyable'])) {
					if($_POST['buyPrice']<0) {
						RentItError('Product', 'CreateProduct', 'Price must not be negative');
					}
					else {
						$product->buyPrice = $_POST['buyPrice'];
					}
				}
				if(isset($_POST['rentable'])) {
					if($_POST['rentPrice']<0) {
						RentItError('Product', 'CreateProduct', 'Price must not be negative');
					}
					else {
						$product->rentPrice = $_POST['rentPrice'];
					}
				}
				try {
					$this->productModel->CreateProduct($_SESSION['username'], $product, $this->getToken());
					return null;
				} catch(BadRequestException $e) {
					RentItError('Product', 'CreateProduct', 'Something went wrong, please try again');	
				} catch (ForbiddenException $e) {
					RentItError('Auth', 'Login', 'Login has expired');
				} catch (NotFoundException $e) {
					RentItError('Product', 'CreateProduct', 'Server error');
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
		}
	}
	
	/**
	 * 
	 * @param int $id
	 */
	public function UpdateProduct($id = null) {
		if(isset($_POST['submit'])) {
			try {
				if(isset($_SESSION['token'])) {
					$user = $this->getToken();
					if($user->type=='contentProvider') {
						$this->productModel->UpdateProduct($product, $this->getToken());
						return null;
					}
				}
			} catch (NotFoundException $e) {
				RentItError('Product', 'UpdateProduct', 'The given product does not belong to you');	
			} catch (Exception $e) {
				RentItError('Product', 'UpdateProduct', 'Server errror');
			}
		} else {
			if(isset($_SESSION['token'])) {
				$user = $this->getUser();
				if($user->type=='contentProvider') {
					$product = $this->productModel->GetProduct($id, $this->getToken);
					return new Product_Widget_EditProduct($product);
				}			
			} else {
				RentItError('Auth', 'Login', 'Authentication needed');
			}
		}
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
	public function StreamProduct($id) {
		if(isset($_SESSION['token'])) {
			$stream = $this->productModel->GetMedia($id, $this->getToken());
			return new StreamProduct($stream);
		} else {
			RentItError('Auth', 'Login', 'Authentication needed');
		}
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
			return $_SESSION['token'];
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
