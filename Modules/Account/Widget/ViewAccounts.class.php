<?php

/*
 * Widget for viewing a list of accounts
 */
class Account_Widget_ViewAccounts extends Widget_Container {
  public function __construct($accounts) {
    $this->SetTitle("Account list");
    foreach ($accounts as $account) {
      $this->widgets[] = new Account_Widget_SmallViewAccount($account);
    }
  }
}
