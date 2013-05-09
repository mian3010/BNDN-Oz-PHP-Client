<?php

class Common_Model_WebService_Test extends PHPUnit_Framework_TestCase {
  public function __construct() {
    require_once(dirname(__FILE__).'/../Modules/Common/Model/WebService.class.php');
    require_once(dirname(__FILE__).'/../Modules/Common/Model/JsonParser.class.php');
  }
  public function testSimpleGetMethod() {
    $ws = new WebService('countries', 'GET');
    $obj = $ws->Execute();
    $this->assertEquals(200, $ws->GetHttpStatusCode());
    $this->assertContains('Over the rainbow', $obj);
  }
  
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
  public function testGetMethodWithToken($token) {
    $ws = new WebService('accounts/Lynette', 'GET');
    $ws->SetToken($token);
    $obj = $ws->Execute();
    $this->assertEquals(200, $ws->GetHttpStatusCode());
    $this->assertObjectHasAttribute('email', $obj);
    $this->assertEquals('lynette@smu', $obj->email);
    return array('token' => $token, 'user' => $obj);
  }
  
  /**
   * @depends testGetMethod
   */ 
  public function testGetMethodWithTokenProduct($token) {
    $ws = new WebService('products/7', 'GET');
    $ws->SetToken($token);
    $obj = $ws->Execute();
    $this->assertEquals(200, $ws->GetHttpStatusCode());
    $this->assertObjectHasAttribute('title', $obj);
    $this->assertEquals('Inception', $obj->title);
    return array('token' => $token, 'product' => $obj);
  }

  /**
   * @depends testGetMethodWithToken
   */
  public function testPutMethod($info) {
    $ws = new WebService('accounts/Lynette', 'PUT');
    $ws->SetToken($info['token']);
    $data = new StdClass();
    $data->address = "newaddress";
    $ws->SetData($data);
    $obj = $ws->Execute();
    $this->assertEquals(204, $ws->GetHttpStatusCode());
    
    $data = new StdClass();
    $data->address = $info['user']->address;
    $ws->SetData($data);
    $ws->Execute();
    $this->assertEquals(204, $ws->GetHttpStatusCode());
  }

  public function testPostMethod() {
    //As we have no way of removing an account, this test would create a new 
    //every time, filling up db. This test has therefore not been implemented
  }
}
