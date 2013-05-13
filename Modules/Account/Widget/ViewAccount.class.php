<?php
/*
 * Widget for viewing a specific account by username
 */
class Account_Widget_ViewAccount extends Widget_Wrapper {
  public function __construct($username, $user, $editable = FALSE, $newAccount = FALSE) {
    $this->classes[] = "clearfix";
    $this->classes[] = "inline";
    $this->AddCss(
      '#' . $this->id . '{ width:100% }
      .editField{ width:150px; }
      ');

    $this->SetTitle($username);
    var_dump($user);
    /// Options
    /// Form

    if($editable){
      $f = new Widget_Form();
      $f->id = "form-account";
      if($newAccount)
        $f->action = UriController::GetAbsolutePath('/Account/CreateUser/'); //TODO username as param?
      else
        $f->action = UriController::GetAbsolutePath('/Account/SaveAccountChanges/' . $username); //TODO username as param?
      $f->method = $newAccount ? 'POST' : 'PUT';

      /// Left slider if own
      $leftWrapper = new Widget_Wrapper();
      $leftWrapper->classes[] = 'inline';
      $leftWrapper->AddCss('#' . $leftWrapper->id . '{ float:left; }');

      // Name
      $cName = new Widget_Wrapper();
      $lName = new Widget_Label('Name ');
      $fName = new Widget_ClickEditField(isset($user->name) ? $user->name : '', $editable);
      $fName->name = 'name';
      $fName->classes[] = 'editField';
      $cName->widgets += array($lName, $fName);
      $leftWrapper->widgets[] = $cName;

      // Email
      $cMail = new Widget_Wrapper();
      $lMail = new Widget_Label('Email ');
      $fMail = new Widget_ClickEditField(isset($user->email) ? $user->email : '', $editable);
      $fMail->name = 'mail';
      $fMail->classes[] = 'editField';
      $cMail->widgets += array($lMail, $fMail);
      $leftWrapper->widgets[] = $cMail;

      // Address
      $cAddress = new Widget_Wrapper();
      $lAddress = new Widget_Label('Address ');
      $fAddress = new Widget_ClickEditField(isset($user->adress) ? $user->adress : '', $editable);
      $fAddress->name = 'address';
      $fAddress->classes[] = 'editField';
      $cAddress->widgets += array($lAddress, $fAddress);
      $leftWrapper->widgets[] = $cAddress;

      // Zipcode
      $cZip = new Widget_Wrapper();
      $lZip = new Widget_Label('Zipcode ');
      $fZip = new Widget_ClickEditField(isset($user->postal) ? $user->postal: '', $editable);
      $fZip->name = 'postal';
      $fZip->classes[] = 'editField';
      $cZip ->widgets += array($lZip, $fZip);
      $leftWrapper->widgets[] = $cZip;

      // Change password
      $cPassword = new Widget_Wrapper();
      $fPassword = new Widget_ClickEditField('Change password ', $editable);
      $fPassword->name = 'password';
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
    $fAbout->name = 'about';
    $fAbout->AddCss('#' . $fAbout->id . '{ border:dashed 1px black; }');
    $cAbout->wrapperTitle = 'About me';
    $cAbout->AddCss('.wrapperTitle{ color: #CA4700; }');
    $cAbout->widgets[] = $fAbout;
    $this->widgets[] = $cAbout;

    /// Right element
    $rightWrapper = new Widget_Wrapper();
    $rightWrapper->classes[] = 'inline';
    $rightWrapper->AddCss('#' . $rightWrapper->id . '{ float:right; width:200px; border:dashed 1px black; }');

    /// Picture
    $img = new Widget_Image('static/img/accountThumb.jpg');
    $img->height = '80px';
    $img->width = '50px';
    $rightWrapper->widgets[] = $img;

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
    $fCountry->name = 'country';
    $fCountry->classes[] = 'editField';
    $cCountry ->widgets += array($lCountry, $fCountry);
    $rightWrapper->widgets[] = $cCountry;

    // DoB
    $cDoB = new Widget_Wrapper();
    $lDoB = new Widget_Label('DoB ');
    $fDoB = new Widget_ClickEditField(isset($user->birth) ? $user->birth: '', $editable);
    $fDoB->name = 'dob';
    $fDoB->classes[] = 'editField';
    $cDoB->widgets += array($lDoB, $fDoB);
    $rightWrapper->widgets[] = $cDoB;

    // Create Date
    $cCd = new Widget_Wrapper();
    $lCd = new Widget_Label('Create date ');
    $fCd = new Widget_ClickEditField(isset($user->created) ? $user->created: '', FALSE);
    $fCd->classes[] = 'editField';
    $cCd->widgets += array($lCd, $fCd);
    $rightWrapper->widgets[] = $cCd;

    $this->widgets[] = $rightWrapper;

    if($editable){
      //Submit button
      $s = new Widget_Button("Save changes");
      $f->widgets[] = $fName;
      $f->widgets[] = $fMail;
      $f->widgets[] = $fAddress;
      $f->widgets[] = $fZip;
      $f->widgets[] = $fPassword;
      $f->widgets[] = $fAbout;
      $f->widgets[] = $fCountry;
      $f->widgets[] = $fDoB;
      $f->widgets[] = $s;
      $rightWrapper->widgets[] = $s;
    }
  }
}