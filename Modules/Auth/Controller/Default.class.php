<?php

class Auth_Controller_Default extends CommonController {
  public function Login() {
    $widget = new Auth_Widget_Login();
    return $widget;
  }
  public function Authenticate() {
    $username = $_POST['tf_login-username'];
    $password = $_POST['tf_login-password'];
    $am = CommonModel::GetModel("Auth");
    try {
      $_SESSION['token'] = $am->GetToken($username, $password);
      $_SESSION['username'] = $username;
      RentItGoto('Account', 'Dashboard');
    } catch (UnauthorizedException $e) {
      RentItError('Auth', 'Login', 'Credentials supplied was wrong.');
    } catch (Exception $e) {
      RentItError('Auth', 'Login', 'Server error. Please try again later.');
    }
  }
}
