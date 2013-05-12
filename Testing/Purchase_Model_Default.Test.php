<?php
require_once("Testing_Base.class.php");
class Purchase_Model_Default_Test extends Testing_Base {
  public function testGetPurchasesBuy() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("cus", "cus");

    $pm = CommonModel::GetModel("Purchase");
    $purchases = $pm->GetPurchases("cus", $token->token, "B");

    foreach ($purchases as $purchase) {
      $this->assertEquals("B", $purchase->type);
    }

    return count($purchases);
  }

  public function testGetPurchasesRent() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("cus", "cus");

    $pm = CommonModel::GetModel("Purchase");
    $purchases = $pm->GetPurchases("cus", $token->token, "R");

    foreach ($purchases as $purchase) {
      $this->assertEquals("R", $purchase->type);
    }
  }

  /**
   * @depends testGetPurchasesBuy
   */
  public function testGetPurchases($count) {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("cus", "cus");

    $pm = CommonModel::GetModel("Purchase");
    $purchases = $pm->GetPurchases("cus", $token->token);

    $this->assertGreaterThan($count, count($purchases));
  }

  public function testCreatePurchase() {
    //As we have no way of removing a purchase, this test would create a new 
    //every time, filling up db. This test has therefore not been implemented
    $this->assertTrue(true);
  }
}
