<?php

class Purchase_Model_Default extends CommonModel {
  public function GetPurchases($username, $buyrent, $token, $info = 'more') {
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

  public function CreatePurchases($username, $purchases, $token) {
    $ws = new WebService('accounts/'.$username.'/purchases', 'POST');
    $ws->SetData($purchases);
    $ws->SetToken($token);
    $purchases = $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return $purchases;
  }
}
