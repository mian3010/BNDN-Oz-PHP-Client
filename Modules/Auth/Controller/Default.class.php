<?php

class Auth_Controller_Default extends CommonController {
  public function Login() {
    $widget = new Auth_Widget_Login();
    return $widget;
  }
  public function Authenticate($username, $password) {
    $am = CommonModel::GetModel("auth");
    try {
      $_SESSION['token'] = $am->GetToken();
      rentit_goto('Account', 'Dashboard');
    } catch (UnauthorizedException $e) {
      rentit_error('Auth', 'Login', array('Credentials supplied was wrong.'));
    } catch (Exception $e) {
      rentit_error('Auth', 'Login', array('Server error. Please try again later.'));
    }
  }
}
