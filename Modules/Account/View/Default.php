<?php

class Account_View_Default extends CommonView {
  /*
   * View for viewing a specific account by username
   * @param $username The username of the account
   * @return A renderable widget
   */
  public function ViewAccount($username) {
    throw new NotImplementedException();
  }

  /*
   * View for editing a specific account by username
   * @param $username The username of the account
   * @return A renderable widget
   */
  public function EditAccount($username) {
    throw new NotImplementedException();
  }

  /*
   * View for viewing a list of accounts
   * @param $types String representing the types to show. A = Admin, C = 
   * Customer, P = Content Provider
   * @param $incBanned Whether or not to include banned users
   * @return A renderable widget
   */
  public function ViewAccounts($types, $incBanned) {
    throw new NotImplementedException();
  }
}
