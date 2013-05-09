<?php
require_once('Testing_Base.class.php');
class Auth_Model_Default_Test extends Testing_Base {
  
  public function testGetToken() {
/*    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");
    $this->assertObjectHasAttribute("token", $token);
    $this->assertObjectHasAttribute("expires", $token);

    $date = strtotime($token->expires);
    $this->assertGreaterThan($date, time());*/
  }

  /*
   * @expectedException UnauthorizedException
   */
  public function testGetTokenUserNotExist() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("WrongUser", "SomePass");
  }
}
