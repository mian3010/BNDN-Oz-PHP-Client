<?php

class Account_Controller_Default extends CommonController {

  public function __construct(){
    parent::__construct();
    $this->accountModel = CommonModel::GetModel("Account");
  }

  public function View($username){
    try {
      if(isset($_SESSION['token'])){
        $user = $this->accountModel->GetAccount($username, $_SESSION['token']->token);
        if(isset($_SESSION['username']) && strtolower($_SESSION['username']) == strtolower($username)){
          return null; //TODO own view
        }
        return null; //TODO auth view
      } else {
        return null; //TODO Goto auth
      }
    } catch (UnauthorizedException $e) {
      //TODO
    } catch (Exception $e){
      //TODO
    }
  }

  public function Create(){
    try {
      if(isset($_SESSION['token']) && isset($_SESSION['username'])){
        $user = $this->accountModel->GetAccount($_SESSION['username'], $_SESSION['token']->token);
        if(strtolower($user->type) == 'admin') return null; //TODO admin view
      }
      return null; //TODO unauth view
    } catch (UnauthorizedException $e) {
      //TODO
    } catch (Exception $e){
      //TODO
    }
  }

  public function ListView($types = 'PC', $incBanned = FALSE){
    try {
      if(isset($_SESSION['token']) && isset($_SESSION['username'])){
        $user = $this->accountModel->GetAccount($_SESSION['username'], $_SESSION['token']->token);
        if(strtolower($user->type) != 'admin') {
          $types = str_ireplace('a', '', $types);
          $incBanned = FALSE;
        }
        $accounts = $this->accountModel->GetAccounts($types, $incBanned, 'more', $_SESSION['token']->token);
        return null; //TODO
      } else {
        //TODO Goto auth
      }
    } catch (UnauthorizedException $e) {
      //TODO
    } catch (Exception $e){
      //TODO
    }
  }

  public function SaveAccountChanges($username){
    //TODO
    // Build info array
    $info = array();

    try{
      $this->accountModel->UpdateAccount($username, $info, $_SESSION['token']->token);
    } catch (UnauthorizedException $e){
      //TODO Goto auth
    } catch (Exception $e){
      //TODO
    }
    return $this->View($username);
  }

  public function SaveNewAccount($username){
    //TODO
    // Build info array
    $info = array();

    try{
      if(isset($_SESSION['token']))
        $this->accountModel->CreateAccount($username, $info, $_SESSION['token']->token);
      else{
        if(isset($info['type']))
          if($info['type']!='Customer')
            return null; //TODO
        $this->accountModel->CreateAccount($username, $info);
      }
    } catch (UnauthorizedException $e){
      //TODO Goto auth
    } catch (Exception $e){
      //TODO
    }
    return $this->Dashboard($username);
  }

  public function Dashboard(){
    if(isset($_SESSION['token']) && isset($_SESSION['username'])){
      return null; //TODO 
    } else
      return null; //TODO goto auth
  }
}