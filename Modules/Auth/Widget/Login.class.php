<?php
/*
 * Widget for logging in
 */
class Auth_Widget_Login extends Widget_Container {
  public function __construct() {
    //Login form
    $f = new Widget_Form();
    $f->id = "form-login";
    $f->action = '/Auth/Authenticate';
    $f->method = 'POST';

    //Username field
    $uw = new Widget_Wrapper();
    $u = new Widget_TextField("Username");
    $u->id = $u->name = "login-username";
    $uw->widgets[] = $u;
    //Password field
    $pw = new Widget_Wrapper();
    $p = new Widget_TextField("Password");
    $p->id = $p->name = "login-password";
    $pw->widgets[] = $p;
    //Submit button
    $s = new Widget_Button("Login");

    //Add fields to form
    $f->widgets[] = $uw;
    $f->widgets[] = $pw;
    $f->widgets[] = $s;

    //Add form to page
    $this->widgets[] = $f;
  }
}
