<?php

class Account_Controller_Default extends CommonController {

  public function __construct(){
    $this->accountModel = CommonModel::GetModel("Account");
  }

  public function View($username){
    try {
      if(isset($_SESSION['token'])){
        $user = $this->accountModel->GetAccount($username, $_SESSION['token']->token);
        $edit = FALSE;
        if(isset($_SESSION['username']) && strtolower($_SESSION['username']) == strtolower($username)){
          $edit = TRUE;
        }
        return new Account_Widget_ViewAccount($username, $user, $edit);;
      } else {
          RentItError('Auth', 'Login', 'Please authenticate');
      }
    } catch (UnauthorizedException $e) {
        RentItError('Auth', 'Login', 'Please authenticate');
    } catch (Exception $e){
        RentItError('Account', 'Dashboard', 'Server error');
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
        RentItError('Auth', 'Login', 'Please authenticate');
    } catch (Exception $e){
        RentItError('Account', 'Dashboard', 'Server error');
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
          RentItError('Auth', 'Login', 'Please authenticate');
      }
    } catch (UnauthorizedException $e) {
        RentItError('Auth', 'Login', 'Please authenticate');
    } catch (Exception $e){
      RentItError('Account', 'Dashboard', 'Server error');
    }
  }

  public function SaveAccountChanges($username){
    //TODO
    // Build info array
    $info = array();

    try{
      $this->accountModel->UpdateAccount($username, $info, $_SESSION['token']->token);
    } catch (UnauthorizedException $e){
        RentItError('Auth', 'Login', 'Please authenticate');
    } catch (Exception $e){
      RentItError('Account', 'Dashboard', 'Server error');
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
        RentItError('Auth', 'Login', 'Please authenticate');
    } catch (Exception $e){
      RentItError('Account', 'Dashboard', 'Server error');
    }
    return $this->Dashboard($username);
  }

  public function Dashboard(){
    if(isset($_SESSION['token']) && isset($_SESSION['username'])){
      return null; //TODO
    } else
        RentItError('Auth', 'Login', 'Please authenticate');
  }
}