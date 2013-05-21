<?php

class Product_Controller_Default extends CommonController {
	
	/**
	 * Constructur. Instantiates the model used
	 */
	public function __construct() {
		$this->productModel = CommonModel::GetModel('Product');
	}
	
  /**
   * View a product
	 * @param $id The id of the product
	 * @return Product_Widget_ViewProduct
	 */
  public function View($id = 0) {
    if($id == 0){
      RentItError('Product not found');
      RentItGoto('Product', 'ViewTypes');
    }
		try {
			if(isset($_SESSION['token'])) $t = $_SESSION['token']->token;
      $product = $this->productModel->GetProduct($id, @$t);
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
	 * View all products
	 * @return Product_Widget_ViewProducts
	 */
	public function ViewAll() {
		try {
			$info = 'detailed';	
      $products = $this->productModel->getProducts($this->getToken());
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
   * Rate a product
   * @param $productId The id of the product to rate
   * @param $rating The rating of the product
   * @return null
   */
  public function Rate($productId, $rating) {
    $pm = $this->productModel;
		try {
      $pm->UpdateRating($productId, $rating, $_SESSION['token']->token);
      RentItSuccess("You rated this product with ".$rating);
      RentItGoto("Product", "View", array($productId));
		} catch (BadRequestException $e) {
      RentItError('Internal error');
      RentItGoto("Product", "View", array($productId));
    } catch (ForbiddenException $e) {
      RentItError('Please authenticate');
      RentItGoto("Product", "View", array($productId));
		} catch (ServerErrorException $e) {
      RentItError('Server error');
      RentItGoto("Product", "View", array($productId));
		}
  }
	
	/**
	 * Search for products
	 * @param $searchString The string to search for
	 * @param $types The types to include
	 * @param $unpublished Whether or not to include unpublished products 
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
   * View product types with preview of four products
   * @return Widget_Wrapper
   */
  public function ViewTypes() {
    $w = new Widget_Wrapper();
    $w->SetTitle('Browse products');
    $w->AddOption("View all products", "Product/ViewAll");
    $pm = $this->productModel;
    $productTypes = $pm->GetProductTypes();
    foreach ($productTypes as $productType) {
      $products = array_slice($pm->GetProducts(null, null, $productType), 0,4);
      $w->widgets[] = new Product_Widget_ViewType($productType, $products);
    }
    return $w;
  }

  /**
   * View all products of a single type
   * @param $productType The product type to display products for
   * @return Product_Widget_ViewType
   */
  public function ViewType($productType) {
    $pm = $this->productModel;
    $products = $pm->GetProducts(null, null, $productType);
    return new Product_Widget_ViewType($productType, $products);
  }
	
	/**
   * Show create product widget
   * @return Product_Widget_CreateProduct
	 */
	public function Create() {
    if(isset($_SESSION['token'])){
      if(isset($_SESSION['type']) && strtolower($_SESSION['type']) == 'content provider')
        return new Product_Widget_CreateProduct();
    } else {
      RentItError('Please authenticate as Content Provider');
      RentItGoto('Auth', 'Login');
    }
	}

  /**
   * Save the new product
   * @return null
   */
  public function SaveNewProduct(){
    if(isset($_SESSION['token']) && isset($_SESSION['username'])){
      if(isset($_SESSION['type']) && strtolower($_SESSION['type']) == 'content provider'){

        $error = FALSE;
        if(!isset($_POST['title']) || trim($_POST['title']) == ''){
          RentItError('Please fill in title');
          $error = TRUE;
        }
        if(!isset($_POST['type']) || trim($_POST['type']) == ''){
          RentItError('Please fill in type');
          $error = TRUE;
        }
        if($error) RentItGoto('Product', 'Create');

        $info = new stdClass();
        $info->title = $_POST['title'];
        $info->type = strtolower($_POST['type']);

        $id = $this->productModel->CreateProduct($_SESSION['username'], $info, $_SESSION['token']->token);

        RentItSuccess('Product created');
        RentItGoto('Product', 'View/'.$id->id);
      }
    } else {
      RentItError('Please authenticate as Content Provider');
      RentItGoto('Auth', 'Login');
    }
  }
	
	/**
	 * Update a product
   * @param $id The id of the product to update
   * @return null
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
    RentItSuccess('Product has been updated');
    RentItGoto('Product', 'View/' . $info['id']);
	}
	
	/**
	 * Upload a media for a product
	 * @param $id The id of the product
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
	 * Upload a thumbnail for a product. Not implemented
   * @param $id The id of the product
   * @return null
	 */
	public function UploadThumbnail($id = null) {
		if(isset($_POST['submit'])) {
			
		} else {
			
		}
	}
	
	/**
	 * Stream a product
	 * @param $id The id of the purchase
	 * @return Product_Widget_StreamProduct
	 */
	public function Stream($tId) {
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

  /**
   * Print the actual stream out
   * @param The id of the purchase
   * @return The stream contents
   */
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
	 * Get the token, or null if it does not exist
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
	 * Get the user from token
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
