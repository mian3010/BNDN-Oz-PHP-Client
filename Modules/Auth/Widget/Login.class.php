<?php
/*
 * Widget for logging in
 */
class Auth_Widget_Login extends Widget_Container {
  public function __construct() {
    //Login form
    $f = new Widget_Form();
    $f->id = "form-login";
    $f->action = UriController::GetAbsolutePath('/Auth/Authenticate');
    $f->method = 'POST';

    //Username field
    $uw = new Widget_Wrapper();
    $ul = new Widget_Label('Username ');
    $ul->classes[] = 'inline';
    $ul->AddCss('#' . $ul->id . '{ width:60px; }');
    $u = new Widget_InputField();
    $uw->classes[] = 'hasALittleBitOfPadding';
    $u->name = "login-username";
    $uw->widgets += array($ul, $u);

    //Password field
    $pw = new Widget_Wrapper();
    $pl = new Widget_Label('Password ');
    $pl->classes[] = 'inline';
    $pl->AddCss('#' . $pl->id . '{ width:60px; }');
    $p = new Widget_InputField("password");
    $pw->classes[] = 'hasALittleBitOfPadding';
    $p->name = "login-password";
    $pw->widgets += array($pl, $p);

    //Submit button
    $sw = new Widget_Wrapper();
    $s = new Widget_Button("Login");
    $s->AddCss('#' . $s->id . '{ width:60px; }');
    $s->classes[] = 'inline';
    $s->classes[] = 'hasALittleBitOfPadding';
    $sw->widgets[] = $s;

    //Create account link
    $hCreate = new Widget_Link('/Account/Create');
    $lCreate = new Widget_Label('Create new account');
    $hCreate->widgets[] = $lCreate;
    $hCreate->classes[] = 'hasALittleBitOfPadding';
    $hCreate->AddCss('#' . $hCreate->id . '{ margin-left:7px; }');
    $sw->widgets[] = $hCreate;

    //Add fields to form
    $f->widgets[] = $uw;
    $f->widgets[] = $pw;
    $f->widgets[] = $sw;

    //Add form to page
    $this->widgets[] = $f;
    $this->SetTitle("Login");
  }
}
