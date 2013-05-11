<?php

class Account_Model_Default extends CommonModel {
  /*
   * Get array of accounts
   * @param $types String defining the types of users to get. A = Admin, C = 
   * Customer, P = Content Provider
   * @param $incBanned Whether or not banned should be included
   * @param $info What info should be returned. String containing either 
   * "username", "more" or "detailed"
   * @param $token Optional authentication token of the user
   * @return Array of users
   */
  public function GetAccounts($types, $incBanned, $info = 'more', $token = null) {
    $ws = new WebService('accounts', 'GET');
    $ws->SetData(array(
      'types' => $types,
      'info' => $info,
      'include_banned' => $incBanned
    ));
    if($token != null) $ws->SetToken($token);
    $data = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $data;
  }

  /*
   * Get a single account by username
   * @param $username The username to get account by
   * @param $token Optional authentication token of the user
   * @return The user
   */
  public function GetAccount($username, $token = null) {
    $ws = new WebService('accounts/' . $username , 'GET');
    if($token != null) $ws->SetToken($token);
    $data = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $data;
  }

  /*
   * Create an account
   * @param $username The username of the new account
   * @param $info The array containing the info of the user
   * @param $token Optional authentication token of the user
   * @return The new user on success
   */
  public function CreateAccount($username, $info, $token = null) {
    $ws = new WebService('accounts/' . $username , 'POST');
    if($token != null) $ws->SetToken($token);
    $ws->SetData($info);
    $data = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $data;
  }

  /*
   * Update an account
   * @param $username The username of the account to update
   * @param $info The array containing the info to update
   * @param $token The authentication token of the user
   * @return The updated user
   */
  public function UpdateAccount($username, $info, $token) {
    $ws = new WebService('accounts/' . $username , 'PUT');
    $ws->SetToken($token);
    $ws->SetData($info);
    $data = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $data;
  }

  /*
   * Get a list of countries supported
   * @return An array of countries supported
   */
  public function GetCountries() {
    $ws = new WebService('countries', 'GET');
    $data = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $data;
  }
}
