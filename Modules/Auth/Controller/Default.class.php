<?php

class Auth_Controller_Default extends CommonController {
  /**
   * View for loggin in a user/showing info when logged in
   * @return Auth_Widget_LoggedIn or Auth_Widget_Login
   */
  public function Login() {
    if(isset($_SESSION['token']) && (isset($_SESSION['username'])))
      return new Auth_Widget_Loggedin($_SESSION['username']);
    return new Auth_Widget_Login();
  }

  /**
   * Logs a user out
   * @return null
   */
  public function LogOut(){ 
    //Destroy session data
    session_destroy();
    //Create a new one, so that we might display message to user
    session_start();
    RentItInfo('Goodbye - Come again!');
    RentItGoto();
  }

  /**
   * Authenticate a user against webservices
   * @return null
   */
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
      // Save type in session
      $am = CommonModel::GetModel("Account");
      $user = $am->GetAccount($username, $_SESSION[token]->token);
      $_SESSION['type'] = $user->type;

      RentItInfo('Welcome!');
      RentItGoto('Account', 'Dashboard');
    } catch (UnauthorizedException $e) {
      RentItError('Credentials supplied was wrong.');
    } catch (Exception $e) {
      RentItError('Server error. Please try again later.');
    }
    RentItGoto('Auth', 'Login');
  }
}
