<?php

class Product_Widget_CreateProduct extends Widget_Form {
  public function __construct() {
    // Title
    $this->SetTitle('Create new Product');
    $this->AddCss(
      '#' . $this->id . '{ border: 1px dashed black; width:100% }
      .editField{ width:150px; }'
    );

    // Form
    $this->action = UriController::GetAbsolutePath('/Product/CreateProduct/');
    $this->method = 'POST';

    // Title
    $cTitle = new Widget_Wrapper();
    $lTitle = new Widget_Label('Product title ');
    $fTitle = new Widget_ClickEditField('');
    $fTitle->name = 'title';
    $fTitle->classes[] = 'editField';
    $cTitle->widgets += array($lTitle, $fTitle);
    $this->widgets[] = $cTitle;


    // Type
    $cType = new Widget_Wrapper();
    $lType = new Widget_Label('Product type ');
    $fType = new Widget_ClickEditField('');
    $fType->name = 'type';
    $fType->classes[] = 'editField';
    $cType->widgets += array($lType, $fType);
    $this->widgets[] = $cType;

    // Button
    $s = new Widget_Button('Create account');
    $this->widgets[] = $s;
  }
}
