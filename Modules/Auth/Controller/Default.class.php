<?php

class Auth_Controller_Default extends CommonController {
  public function Login() {
    if(isset($_SESSION['token']))
      return new Auth_Widget_Loggedin();
    return new Auth_Widget_Login();
  }
  public function Authenticate() {
    if (!isset($_POST['login-username']) ||
        !isset($_POST['login-password']) ||
        empty($_POST['login-username']) ||
        empty($_POST['login-password']))  {
          RentItError('Both username and password must be entered');
          RentItGoto("Auth", "Login");
        }

    $username = $_POST['login-username'];
    $password = $_POST['login-password'];
    $am = CommonModel::GetModel("Auth");
    try {
      $_SESSION['token'] = $am->GetToken($username, $password);
      $_SESSION['username'] = $username;
      RentItGoto('Account', 'Dashboard');
    } catch (UnauthorizedException $e) {
      RentItError('Credentials supplied was wrong.');
    } catch (Exception $e) {
      RentItError('Server error. Please try again later.');
    }
    RentItGoto('Auth', 'Login');
  }
}
