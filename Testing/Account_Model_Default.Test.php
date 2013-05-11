<?php
require_once('Testing_Base.class.php');
class Account_Model_Default_Test extends Testing_Base {

  public function testGetAccountsWToken() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccounts('ACP', FALSE, 'more', $token->token);

    $this->assertTrue($accounts !== null);
  }

  public function testGetAccounts() {
    $am = CommonModel::GetModel("Auth");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccounts('C', FALSE, 'more');

    $this->assertTrue($accounts !== null);
  }

  public function testGetAccountAdmin() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccount('Lynette', $token->token);

    $this->assertTrue($accounts !== null);
  }

  public function testGetAccountCustomer() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccount('Cus', $token->token);

    $this->assertTrue($accounts !== null);
  }
}