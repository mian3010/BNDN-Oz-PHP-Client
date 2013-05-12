<?php

class Auth_Controller_Default extends CommonController {
  public function Login() {
    $widget = new Auth_Widget_Login();
    return $widget;
  }
  public function Authenticate() {
    if (!isset($_POST['login-username']) ||
        !isset($_POST['login-password']) ||
        empty($_POST['login-username']) ||
        empty($_POST['login-password']))
      RentItError('Auth', 'Login', 'Both username and password must be entered');

    $username = $_POST['login-username'];
    $password = $_POST['login-password'];
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
