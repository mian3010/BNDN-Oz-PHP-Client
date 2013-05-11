<?php
/*
 * Widget for logging in
 */
class Auth_Widget_Login extends Widget_Container {
  public function __construct() {
    //Username field
    $username = new Widget_TextField("Username");
    $username->id = $username->name = "login-username";
    $this->widgets[] = $username;
    //Password field
    $password = new Widget_TextField("Password");
    $password->id = $password->name = "login-username";
    $this->widgets[] = $password;

    $this->AddOption("lol", "lol");
    $this->AddOption("lol2", "lol2");
    $this->AddOption("lol3", "lol3");
    $this->AddOption("lol4", "lol4");
    $this->AddOption("lol5", "lol5");
  }
}
