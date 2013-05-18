<?php

class Credits_Model_Default extends CommonModel {
  /*
   * Add credits to an account
   * @param $token Authentication token with account information
   * @param $amount Amount of credits to be added
   * @return TRUE
   */
  public function UpdateCredits($token, $amount) {
    $ws = new WebService('credits', 'POST');
    if($token != null) $ws->SetToken($token);
    $ws->SetData(array(
      'credits' => $amount
    ));
    $ws->Execute();
    $this->ThrowExceptionIfError($ws->GetHttpStatusCode());
    return TRUE;
  }
}
