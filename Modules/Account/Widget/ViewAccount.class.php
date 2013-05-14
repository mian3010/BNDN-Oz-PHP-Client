<?php
/*
 * Widget for viewing a specific account by username
 */
class Account_Widget_ViewAccount extends Widget_Form {
  public function __construct($username, $user, $editable = FALSE) {
    $this->classes[] = "clearfix";
    $this->AddCss(
      '#' . $this->id . '{ width:100%; position: relative; }
      .editField{ width:150px; }
      ');

    $this->SetTitle($username);
    var_dump($user);
    /// Options
    $this->AddOption('Dashboard', 'Account/Dashboard');

    if($editable){
      /// Form
      $this->action = UriController::GetAbsolutePath('/Account/SaveAccountChanges/' . $username);
      $this->method = 'POST';

      /// Left slider if own
      $leftWrapper = new Widget_Wrapper();
      $leftWrapper->classes[] = 'hasALittleBitOfPadding';

      // Name
      $cName = new Widget_Wrapper();
      $lName = new Widget_Label('Name ');
      $fName = new Widget_ClickEditField(isset($user->name) ? $user->name : '', !$editable);
      $fName->name = 'name';
      $fName->classes[] = 'editField';
      $cName->classes[] = 'hasALittleBitOfPadding';
      $cName->widgets += array($lName, $fName);
      $leftWrapper->widgets[] = $cName;

      // Email
      $cMail = new Widget_Wrapper();
      $lMail = new Widget_Label('Email ');
      $fMail = new Widget_ClickEditField(isset($user->email) ? $user->email : '', !$editable);
      $fMail->name = 'email';
      $fMail->classes[] = 'editField';
      $cMail->classes[] = 'hasALittleBitOfPadding';
      $cMail->widgets += array($lMail, $fMail);
      $leftWrapper->widgets[] = $cMail;

      // Address
      $cAddress = new Widget_Wrapper();
      $lAddress = new Widget_Label('Address ');
      $fAddress = new Widget_ClickEditField(isset($user->adress) ? $user->adress : '', !$editable);
      $fAddress->name = 'address';
      $fAddress->classes[] = 'editField';
      $cAddress->classes[] = 'hasALittleBitOfPadding';
      $cAddress->widgets += array($lAddress, $fAddress);
      $leftWrapper->widgets[] = $cAddress;

      // Zipcode
      $cZip = new Widget_Wrapper();
      $lZip = new Widget_Label('Zipcode ');
      $fZip = new Widget_ClickEditField(isset($user->postal) ? $user->postal: '', !$editable);
      $fZip->name = 'postal';
      $fZip->classes[] = 'editField';
      $cZip->classes[] = 'hasALittleBitOfPadding';
      $cZip ->widgets += array($lZip, $fZip);
      $leftWrapper->widgets[] = $cZip;

      // Change password
      $cPassword = new Widget_Wrapper();
      $fPassword = new Widget_ClickEditField('Change password ', !$editable);
      $fPassword->name = 'password';
      $fPassword->classes[] = 'editField';
      $cPassword->classes[] = 'hasALittleBitOfPadding';
      $cPassword->widgets[] = $fPassword;
      $leftWrapper->widgets[] = $cPassword;

      // Add slider to this
      if($editable){
        $slider = new Widget_Slider();
        $slider->widgets[] = $leftWrapper;
        $slider->AddCss('.slider{ margin-right: 5px; }');
        $slider->SlideLeft();
      }
    }



    /// Right element
    $rightWrapper = new Widget_Wrapper();
    $rightWrapper->AddCss('#' . $rightWrapper->id . '{ width:280px; border:dashed 1px black; }');
    $rightWrapper->classes[] = 'hasALittleBitOfPadding';
    $rightWrapper->classes[] = 'right';

    /// Picture
    $img = new Widget_Image('static/img/accountThumb.jpg');
    $img->height = '180';
    $img->width = '280';
    $rightWrapper->widgets[] = $img;

    // Type
    $cType = new Widget_Wrapper();
    $fType = new Widget_ClickEditField($user->type, TRUE);
    $fType->classes[] = 'editField';
    $cType->classes[] = 'hasALittleBitOfPadding';
    $cType ->widgets[] = $fType;
    $rightWrapper->widgets[] = $cType;

    // Country
    $cCountry = new Widget_Wrapper();
    $lCountry = new Widget_Label('Country ');
    $fCountry = new Widget_ClickEditField(isset($user->country) ? $user->country : '', !$editable);
    $fCountry->name = 'country';
    $fCountry->classes[] = 'editField';
    $cCountry->classes[] = 'hasALittleBitOfPadding';
    $cCountry ->widgets += array($lCountry, $fCountry);
    $rightWrapper->widgets[] = $cCountry;

    // DoB
    $cDoB = new Widget_Wrapper();
    $lDoB = new Widget_Label('DoB ');
    $fDoB = new Widget_ClickEditField(isset($user->birth) ? $user->birth: '', !$editable);
    $fDoB->name = 'birth';
    $fDoB->classes[] = 'editField';
    $cDoB->classes[] = 'hasALittleBitOfPadding';
    $cDoB->widgets += array($lDoB, $fDoB);
    $rightWrapper->widgets[] = $cDoB;

    // Create Date
    $cCd = new Widget_Wrapper();
    $lCd = new Widget_Label('Create date ');
    $fCd = new Widget_Date(isset($user->created) ? $user->created: '');
    $fCd->classes[] = 'editField';
    $cCd->classes[] = 'hasALittleBitOfPadding';
    $cCd->widgets += array($lCd, $fCd);
    $rightWrapper->widgets[] = $cCd;

    //$this->widgets[] = $rightWrapper;

    /// Middle element
    /// About me
    $cAbout = new Widget_Wrapper();
    $fAbout = new Widget_ClickEditField(isset($user->about) ? $user->about : '', !$editable);
    $fAbout->name = 'about';
    //$fAbout->AddCss('#' . $fAbout->id . '{ border:dashed 1px black; }');
    $cAbout->wrapperTitle = 'About me';
    $cAbout->classes[] = 'hasALittleBitOfPadding';
    $cAbout->widgets[] = $fAbout;

    $wAbout = new Widget_Wrapper();
    $wAbout->widgets[] = $slider;
    $wAbout->widgets[] = $rightWrapper;
    $wAbout->widgets[] = $cAbout;
    $this->widgets[] = $wAbout;

    if($editable){
      //Submit button
      $s = new Widget_Button("Save changes");
      $s->classes[] = 'hasALittleBitOfPadding';
      $rightWrapper->widgets[] = $s;
    }
  }
}