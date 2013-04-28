<?php

class Account_Controller_Default extends CommonController {
  /*
   * Get array of accounts
   * @param $types String defining the types of users to get. A = Admin, C = 
   * Customer, P = Content Provider
   * @param $incBanned Whether or not banned should be included
   * @param $info What info should be returned. String containing either 
   * "username", "more" or "detailed"
   * @return Array of users
   */
  public function GetAccounts($types, $incBanned, $info) {
    throw new NotImplementedException();
  }

  /*
   * Get a single account by username
   * @param $username The username to get account by
   * @return The user
   */
  public function GetAccount($username) {
    throw new NotImplementedException();
  }

  /*
   * Create an account
   * @param $username The username of the new account
   * @param $info The array containing the info of the user
   * @return The new user on success
   */
  public function CreateAccount($username, $info) {
    throw new NotImplementedException();
  }

  /*
   * Update an account
   * @param $username The username of the account to update
   * @param $info The array containing the info to update
   * @return The updated user
   */
  public function UpdateAccount($username, $info) {
    throw new NotImplementedException();
  }

  /*
   * Get a list of countries supported
   * @return An array of countries supported
   */
  public function GetCountries() {
    throw new NotImplementedException();
  }
}
