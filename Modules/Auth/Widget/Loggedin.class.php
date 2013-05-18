<?php

class Auth_Widget_Loggedin extends Widget_Wrapper {
  public function __construct($username) {
    // Wrapper
    $wrap = new Widget_Wrapper();
    $wrap->classes[] = 'hasALittleBitOfPadding';
    $this->widgets[] = $wrap;
    
    // Dashboard
    $wDash = new Widget_Wrapper();
    $hDash = new Widget_Link('/Account/Dashboard');
    $lDash = new Widget_Label('Dashboard');
    $hDash->widgets[] = $lDash;
    $wDash->classes[] = 'hasALittleBitOfPadding';
    $hDash->AddCss('#' . $hDash->id . '{ margin-left:7px; }');
    $wDash->widgets[] = $hDash;
    $wrap->widgets[] = $wDash;

    // Edit profile
    $wEdit = new Widget_Wrapper();
    $hEdit = new Widget_Link('/Account/View/' . $username);
    $lEdit = new Widget_Label('Edit profile');
    $hEdit->widgets[] = $lEdit;
    $wEdit->classes[] = 'hasALittleBitOfPadding';
    $hEdit->AddCss('#' . $hEdit->id . '{ margin-left:7px; }');
    $wEdit->widgets[] = $hEdit;
    $wrap->widgets[] = $wEdit;


    // Credits
    $wC = new Widget_Wrapper();
    $wC->classes[] = 'hasALittleBitOfPadding';
    $wC->AddCss('#' . $wC->id . '{ margin-left:7px; }');
    $cc = new Credits_Controller_Default();
    $wC->widgets[] = $cc->GetCredits();
    $wrap->widgets[] = $wC;

    // Buy credits
    $wCred = new Widget_Wrapper();
    $hCred = new Widget_Link('/Credits/BuyCredits');
    $lCred = new Widget_Label('Buy more credits');
    $hCred->widgets[] = $lCred;
    $wCred->classes[] = 'hasALittleBitOfPadding';
    $hCred->AddCss('#' . $hCred->id . '{ margin-left:7px; }');
    $wCred->widgets[] = $hCred;
    $wrap->widgets[] = $wCred;
    
    // Logout
    $wLog = new Widget_Wrapper();
    $hLog = new Widget_Link('/Auth/Logout');
    $lLog = new Widget_Label('Log out');
    $hLog->widgets[] = $lLog;
    $wLog->classes[] = 'hasALittleBitOfPadding';
    $hLog->AddCss('#' . $hLog->id . '{ margin-left:7px; }');
    $wLog->widgets[] = $hLog;
    $wrap->widgets[] = $wLog;
  }
}
