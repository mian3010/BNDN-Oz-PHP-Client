<?php

class Purchase_Model_Default extends CommonModel {
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
  
  public function GetPurchase($username, $token, $tId) {
    $ws = new WebService('accounts/'.$username.'/purchases/'.$tId, 'GET');
    if($token!=null) $ws->SetToken($token);
    $object = $ws->Execute();
    $code = $ws->GetHttpStatusCode();
    $this->ThrowExceptionIfError($code);
    return $object;
  }

  public function GetPurchaseByPid($username, $token, $pId) {
    $purchases = $this->GetPurchases($username, $token);
    foreach ($purchases as $purchase) {
      if ($purchase->product == $pId) return $purchase;
    }
    return null;
  }

  public function CreatePurchases($username, $purchases, $token) {
    $ws = new WebService('accounts/'.$username.'/purchases', 'POST');
    $ws->SetData($purchases);
    $ws->SetToken($token);
    $purchases = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $purchases;
  }
}
