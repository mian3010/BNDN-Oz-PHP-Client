<?php
  require_once('Testing_Base.class.php');
class Credits_Model_Default_Test extends Testing_Base {

  public function testUpdateCredits(){
    $am = CommonModel::GetModel("Auth");
    $acm = CommonModel::GetModel("Account");
    $cm = CommonModel::GetModel("Credits");

    $token = $am->GetToken("Wauv", "Wauv");

    $account = $acm->GetAccount('Wauv', $token->token);

    $prevCred = $account->credits;
    $addCred = "30";

    $cm-> UpdateCredits($token->token, $addCred);

    $account = $acm->GetAccount('Wauv', $token->token);
    $resCred = $account->credits;

    $this->assertTrue($prevCred+$addCred == $resCred);
  }

  public function testUpdateCreditsNegative(){
    $am = CommonModel::GetModel("Auth");
    $acm = CommonModel::GetModel("Account");
    $cm = CommonModel::GetModel("Credits");

    $token = $am->GetToken("Wauv", "Wauv");

    $account = $acm->GetAccount('Wauv', $token->token);

    $prevCred = $account->credits;
    $addCred = "-30";

    $this->setExpectedException('BadRequestException');
    $cm-> UpdateCredits($token->token, $addCred);
  }
}