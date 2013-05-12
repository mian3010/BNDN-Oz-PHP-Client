<?php
/*
 * Widget for viewing a specific account by username
 */
class Account_Widget_ViewAccount extends Widget_Container {
  public function __construct($username, $user, $editable = FALSE, $newAccount = FALSE) {
    $editFieldSize = 150;
    $this->SetTitle($username);
    var_dump($user);
    // Options
    // Form
    if($editable){
      $f = new Widget_Form();
      $f->id = "form-login";
      $f->action = UriController::GetAbsolutePath('/Accounts/' . $username);
      $f->method = $newAccount ? 'POST' : 'PUT';

      // Left slider if own
      $leftContainer = new Widget_Container();

      // Name
      $cName = new Widget_Wrapper();
      $lName = new Widget_Label('Name ');
      $fName = new Widget_ClickEditField(isset($user->name) ? $user->name : '');
      $fName->AddCss('#' . $fName->id . '{ width:' . $editFieldSize . 'px; }');
      $cName->widgets += array($lName, $fName);
      $leftContainer->widgets[] = $cName;

      // Email
      $cMail = new Widget_Wrapper();
      $lMail = new Widget_Label('Email ');
      $fMail = new Widget_ClickEditField(isset($user->email) ? $user->email : '');
      $fMail->AddCss('#' . $fMail->id . '{ width:' . $editFieldSize . 'px; }');
      $cMail->widgets += array($lMail, $fMail);
      $leftContainer->widgets[] = $cMail;

      // Address
      $cAddress = new Widget_Wrapper();
      $lAddress = new Widget_Label('Address ');
      $fAddress = new Widget_ClickEditField(isset($user->adress) ? $user->adress : '');
      $fAddress->AddCss('#' . $fAddress->id . '{ width:' . $editFieldSize . 'px; }');
      $cAddress->widgets += array($lAddress, $fAddress);
      $leftContainer->widgets[] = $cAddress;

      // Zipcode
      $cZip = new Widget_Wrapper();
      $lZip = new Widget_Label('Zipcode ');
      $fZip = new Widget_ClickEditField(isset($user->postal) ? $user->postal: '');
      $fZip->AddCss('#' . $fZip->id . '{ width:' . $editFieldSize . 'px; }');
      $cZip ->widgets += array($lZip, $fZip);
      $leftContainer->widgets[] = $cZip;

      // Country
      $cCountry = new Widget_Wrapper();
      $lCountry = new Widget_Label('Country ');
      $fCountry = new Widget_ClickEditField(isset($user->country) ? $user->country : '');
      $fCountry->AddCss('#' . $fCountry->id . '{ width:' . $editFieldSize . 'px; }');
      $cCountry ->widgets += array($lCountry, $fCountry);
      $leftContainer->widgets[] = $cCountry;

      // Change password
      $cPassword = new Widget_Wrapper();
      $fPassword = new Widget_ClickEditField('Change password ');
      $fPassword->AddCss('#' . $fPassword->id . '{ width:' . $editFieldSize . 'px; }');
      $cPassword->widgets[] = $fPassword;
      $leftContainer->widgets[] = $cPassword;

      // Add slider to this
      $slider = new Widget_Slider();
      $slider->widgets[] = $leftContainer;
      $slider->SlideLeft();
      $this->widgets[] = $slider;
    }

    // About me
    $cAbout = new Widget_Container();
    //if($editable)
      //$fAbout = new Widget_ClickEditField(isset($user->))

    // Picture
    // Right atrbs
    // Add to form
  }
}
