<?php

/*
 * Widget for creating an account
 */
class Account_Widget_CreateAccount extends Widget_Form {
  public function __construct($admin = FALSE) {
    // Title
    $this->SetTitle('Create account');
    $this->AddCss(
      '#' . $this->id . '{ border: 1px dashed black; width:100% }
      .editField{ width:150px; }'
    );

    // Form
    $this->action = UriController::GetAbsolutePath('/Account/SaveNewAccount/');
    $this->method = 'POST';

    // Username
    $cUser = new Widget_Wrapper();
    $lUser = new Widget_Label('Username ');
    $fUser = new Widget_ClickEditField('');
    $fUser->name = 'username';
    $fUser->classes[] = 'editField';
    $cUser->widgets += array($lUser, $fUser);
    $this->widgets[] = $cUser;

    // Email
    $cEmail = new Widget_Wrapper();
    $lEmail = new Widget_Label('Email ');
    $fEmail = new Widget_ClickEditField('');
    $fEmail->name = 'email';
    $fEmail->classes[] = 'editField';
    $cEmail->widgets += array($lEmail, $fEmail);
    $this->widgets[] = $cEmail;

    // Password
    $cPassword = new Widget_Wrapper();
    $lPassword = new Widget_Label('Password ');
    $fPassword = new Widget_ClickEditField('');
    $fPassword->name = 'password';
    $fPassword->classes[] = 'editField';
    $cPassword->widgets += array($lPassword, $fPassword);
    $this->widgets[] = $cPassword;

    // Type
    if($admin){
      $cType = new Widget_Wrapper();
      $lType = new Widget_Label('Account type ');
      $fType = new Widget_ClickEditField('Customer');
      $fType->name = 'type';
      $fType->classes[] = 'editField';
      $cType->widgets += array($lType, $fType);
      $this->widgets[] = $cType;
    }
    // Button
    $s = new Widget_Button('Create account');
    $this->widgets[] = $s;
  }
}
