<?php
/*
 * Widget for viewing a specific account by username
 */
class Account_Widget_ViewAccount extends Widget_Wrapper {
  public function __construct($username, $user, $editable = FALSE, $newAccount = FALSE) {
    $this->classes[] = "clearfix";
    $this->AddCss(
      '#' . $this->id . '{ width:100% }
      .editField{ width:150px; }
      .inline{ display:inline-block; }
      ');

    $this->SetTitle($username);
    var_dump($user);
    /// Options
    /// Form

    if($editable){
      $f = new Widget_Form();
      $f->id = "form-login";
      $f->action = UriController::GetAbsolutePath('/Accounts/' . $username);
      $f->method = $newAccount ? 'POST' : 'PUT';

      /// Left slider if own
      $leftWrapper = new Widget_Wrapper();
      $leftWrapper->classes[] = 'inline';
      $leftWrapper->AddCss('#' . $leftWrapper->id . '{ float:left; width:200px; }');

      // Name
      $cName = new Widget_Wrapper();
      $lName = new Widget_Label('Name ');
      $fName = new Widget_ClickEditField(isset($user->name) ? $user->name : '');
      $fName->classes[] = 'editField';
      $cName->widgets += array($lName, $fName);
      $leftWrapper->widgets[] = $cName;

      // Email
      $cMail = new Widget_Wrapper();
      $lMail = new Widget_Label('Email ');
      $fMail = new Widget_ClickEditField(isset($user->email) ? $user->email : '');
      $fMail->classes[] = 'editField';
      $cMail->widgets += array($lMail, $fMail);
      $leftWrapper->widgets[] = $cMail;

      // Address
      $cAddress = new Widget_Wrapper();
      $lAddress = new Widget_Label('Address ');
      $fAddress = new Widget_ClickEditField(isset($user->adress) ? $user->adress : '');
      $fAddress->classes[] = 'editField';
      $cAddress->widgets += array($lAddress, $fAddress);
      $leftWrapper->widgets[] = $cAddress;

      // Zipcode
      $cZip = new Widget_Wrapper();
      $lZip = new Widget_Label('Zipcode ');
      $fZip = new Widget_ClickEditField(isset($user->postal) ? $user->postal: '');
      $fZip->classes[] = 'editField';
      $cZip ->widgets += array($lZip, $fZip);
      $leftWrapper->widgets[] = $cZip;

      // Change password
      $cPassword = new Widget_Wrapper();
      $fPassword = new Widget_ClickEditField('Change password ');
      $fPassword->classes[] = 'editField';
      $cPassword->widgets[] = $fPassword;
      $leftWrapper->widgets[] = $cPassword;

      // Add slider to this
      $slider = new Widget_Slider();
      $slider->widgets[] = $leftWrapper;
      $slider->SlideLeft();
      $this->widgets[] = $slider;
    }

    /// Middle element
    /// About me
    $cAbout = new Widget_Wrapper();
    $cAbout->classes[] = 'inline';
    $fAbout = new Widget_ClickEditField(isset($user->about) ? $user->about : '', $editable);
    $cAbout->SetTitle('About me');
    $cAbout->AddCss('.title{ color: #CA4700; }');
    $cAbout->widgets[] = $fAbout;
    $this->widgets[] = $cAbout;

    /// Picture


    /// Right element
    $rightWrapper = new Widget_Wrapper();
    $rightWrapper->classes[] = 'inline';
    $rightWrapper->AddCss('#' . $rightWrapper->id . '{ float:right; width:200px; }');

    // Type
    $cType = new Widget_Wrapper();
    $fType = new Widget_ClickEditField($user->type, FALSE);
    $fType->classes[] = 'editField';
    $cType ->widgets[] = $fType;
    $rightWrapper->widgets[] = $cType;

    // Country
    $cCountry = new Widget_Wrapper();
    $lCountry = new Widget_Label('Country ');
    $fCountry = new Widget_ClickEditField(isset($user->country) ? $user->country : '', $editable);
    $fCountry->classes[] = 'editField';
    $cCountry ->widgets += array($lCountry, $fCountry);
    $rightWrapper->widgets[] = $cCountry;

    // DoB
    $cDoB = new Widget_Wrapper();
    $lDoB = new Widget_Label('DoB ');
    $fDoB = new Widget_ClickEditField(isset($user->birth) ? $user->birth: '', $editable);
    $fDoB->classes[] = 'editField';
    $cDoB->widgets += array($lDoB, $fDoB);
    $rightWrapper->widgets[] = $cDoB;

    // Create Date
    $cCd = new Widget_Wrapper();
    $lCd = new Widget_Label('Create date ');
    $fCd = new Widget_ClickEditField(isset($user->created) ? $user->created: '', $editable);
    $fCd->classes[] = 'editField';
    $cCd->widgets += array($lCd, $fCd);
    $rightWrapper->widgets[] = $cCd;

    $this->widgets[] = $rightWrapper;

    if($editable){
      // Add to form

      //Submit button
      $s = new Widget_Button("Save changes");
      $rightWrapper->widgets[] = $s;
    }
  }
}
