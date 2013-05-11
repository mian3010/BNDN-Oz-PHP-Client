<?php
/*
 * Widget for viewing a specific account by username
 */
class Account_Widget_ViewAccount extends Widget_Container {
  public function __construct($user, $editable = FALSE, $newAccount = FALSE) {
    // Options
    // Form
    if($editable){
      $f = new Widget_Form();
      $f->id = "form-login";
      $f->action = UriController::GetAbsolutePath('/Accounts/' . $user['username']);
      $f->method = $newAccount ? 'POST' : 'PUT';

      // Left slider if own
      $leftContainer = new Widget_Container();
      $cName = new Widget_Container();
      $lName = new Widget_Label('Name');
      $fName = new Widget_ClickEditField(isset($user['name']) ? $user['name'] : '');
      $cName->widgets += array($lName, $fName);

      $this->widgets[] = new Widget_Slider($leftContainer);
    }
    // About me
    // Picture
    // Right atrbs
    // Add to form
  }
}
