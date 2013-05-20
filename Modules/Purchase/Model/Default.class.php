<?php

class Purchase_Model_Default extends CommonModel {
  /**
   * Get all purchases
   * @param $username The username to get purchases by
   * @param $token The token to send along
   * @param $buyrent Whether or not to include both buy and rent
   * @param $info Level of detail
   * @return Array of purchases
   */
  public function GetPurchases($username, $token, $buyrent = "BR", $info = 'more') {
    $ws = new WebService('accounts/'.$username.'/purchases', 'GET');
    $ws->SetData(array(
      'info' => $info,
      'purchases' => $buyrent,
    ));
    $ws->SetToken($token);
    $purchases = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $purchases;
  }

  /**
   * Get a single purchase
   * @param $username The username to get purchase by
   * @param $token Token to send along
   * @param $tId The purchase id
   * @return The single purchase
   */
  public function GetPurchase($username, $token, $tId) {
    $ws = new WebService('accounts/'.$username.'/purchases/'.$tId, 'GET');
    if($token!=null) $ws->SetToken($token);
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }

  /**
   * Get a purchase by product id
   * @param $username The username to get purchase by
   * @param $token The token to send along 
   * @param $pId The product id to get purchase by
   * @return The single purchase
   */
  public function GetPurchaseByPid($username, $token, $pId, $type) {
    $return = array();
    $purchases = $this->GetPurchases($username, $token);
    foreach ($purchases as $purchase) {
      if ($purchase->product == $pId && $purchase->type == $type) $return[] = $purchase;
    }
    return count($return) == 0 ? null : $return;
  }

  /**
   * Create a list of purchases
   * @param $username The username to create purchase for
   * @param $purchases The purchases to create
   * @param $token Token to send along
   * @return The purchases
   */
  public function CreatePurchases($username, $purchases, $token) {
    $ws = new WebService('accounts/'.$username.'/purchases', 'POST');
    $ws->SetData($purchases);
    $ws->SetToken($token);
    $purchases = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $purchases;
  }
}
