<?php
require_once('Testing_Base.class.php');
class Product_Model_Default_Test extends Testing_Base {
	
	public function testGetMethod() {
		$ws = new WebService('auth', 'GET');
		$ws->SetData(array(
				'user' => 'Lynette',
				'password' => 'Awesome',
		));
		$obj = $ws->Execute();
		$this->assertEquals(200, $ws->GetHttpStatusCode());
		$this->assertObjectHasAttribute('token', $obj);
		$this->assertObjectHasAttribute('expires', $obj);
		return $obj->token;
	}
	
	/**
	 * @depends testGetMethod
	 */
	public function testGetProducts($token) {
		$model = CommonModel::GetModel('Product');
		$products = $model->GetProducts(null, null, false, 'id', $token);
		var_dump($products);
		
	}
	
	/**
	 * @depends testGetMethod
	 */
	public function testFailGetProducts($token) {
		$this->setExpectedException('BadRequestException');
		$model = CommonModel::GetModel('Product');
		$products = $model->GetProducts(null, null, true, 'id', null);
	}
	
	/**
	 * 
	 * @depends testGetMethod
	 */
	public function testGetProduct($token) {
		$model = CommonModel::GetModel('Product');
		$product = $model->GetProduct(7, $token);
		$this->assertObjectHasAttribute('title', $product);
	}
	
	/**
	 * @depends testGetMethod
	 */
	public function testGetMedia($token) {
		$model = CommonModel::GetModel('Product');
		$stream = $model->GetMedia(7, $token);
		var_dump($stream);
	}
}