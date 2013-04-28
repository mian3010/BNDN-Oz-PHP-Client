<?php

class Auth_Model_Default extends CommonModel {
  /*
   * Get token for a user.
   * @param $user Username of user
   * @param $pass Password for user
   */
  public function GetToken($user, $pass) {
    throw new NotImplemetedException();
  }
}
