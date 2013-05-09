<?php
var_dump("lol");
class Auth_Model_Default extends CommonModel {
  /*
   * Get token for a user.
   * @param $user Username of user
   * @param $pass Password for user
   */
  public function GetToken($user, $pass) {
    $ws = new WebService('auth', 'GET');
    $ws->SetData(array(
      'user' => $user,
      'password' => $pass,
    ));
    $token = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $token;
  }
}
