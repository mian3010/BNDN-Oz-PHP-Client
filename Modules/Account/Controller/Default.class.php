<?php

class Account_Controller_Default extends CommonController {

  public function __construct(){
    $this->accountModel = CommonModel::GetModel("Account");
  }

  public function View($username){
    try {
      if(isset($_SESSION['token'])){
        $user = $this->accountModel->GetAccount($username, $_SESSION['token']->token);
        $requester = $this->accountModel->GetAccount($_SESSION['username'], $_SESSION['token']->token);
        $edit = FALSE;
        if(isset($_SESSION['username']) && strtolower($_SESSION['username']) == strtolower($username))
          $edit = TRUE;
        else if(strtolower($requester->type) == 'admin')
          $edit = TRUE;
        return new Account_Widget_ViewAccount($username, $user, $edit);;
      } else {
        RentItError('Please authenticate');
        RentItGoto("Auth", "Login");
      }
    } catch (UnauthorizedException $e) {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItError(print_r($e, TRUE));
      RentItGoto("Account", "Dashboard");
    }
  }

  public function Create(){
    try {
      $admin = FALSE;
      if(isset($_SESSION['token']) && isset($_SESSION['username'])){
        $user = $this->accountModel->GetAccount($_SESSION['username'], $_SESSION['token']->token);
        if(strtolower($user->type) == 'admin') $admin = TRUE;
      }
      return new Account_Widget_CreateAccount($admin);
    } catch (UnauthorizedException $e) {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto("Account", "Dashboard");
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
        RentItError('Please authenticate');
        RentItGoto("Auth", "Login");
      }
    } catch (UnauthorizedException $e) {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto("Account", "Dashboard");
    }
  }

  public function SaveAccountChanges($username){
    // Build info array
    $info = array();
    file_put_contents('test.txt', print_r($_POST, TRUE));
    foreach ($_POST as $k => $v){
      if(trim($v) != '' && (strtolower(trim($v)) != 'change password'))
        $info[$k] = $v;
    }

    try{
      if(isset($_SESSION['token']))
        $this->accountModel->UpdateAccount($username, $info, $_SESSION['token']->token);
      else{
        RentItError('Please authenticate');
        RentItGoto("Auth", "Login");
      }
    } catch (UnauthorizedException $e){
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto("Account", "Dashboard");
    }
    RentItGoto('Account', 'View/' . $username);
  }

  public function SaveNewAccount(){
    // Build info array
    $info = array();
    file_put_contents('test.txt', print_r($_POST, TRUE));
    foreach ($_POST as $k => $v){
      if(!strtolower(trim($v)) == 'change password')
      $info[$k] = $v;
    }

    try{
      if(!isset($info['username']))
        RentItError('Please fillout username');
      if(!isset($info['password']))
        RentItError('Please fillout password');
      if(!isset($info['type']) || trim($info['type'])=='')
        $info['type'] = 'Customer';
      RentItGoto("Account", "Create");
      $this->accountModel->CreateAccount($info['username'], $info, $_SESSION['token']->token);
    } catch (UnauthorizedException $e){
      RentItError('Permission denied');
      RentItGoto("Account", "Create");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto("Account", "Dashboard");
    }
    RentItGoto('Account', 'View/' . $info['username']);
  }

  public function Dashboard(){
    if(isset($_SESSION['token']) && isset($_SESSION['username'])){
      return new Account_Widget_AccountDashboard();
    } else {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    }
  }
}
