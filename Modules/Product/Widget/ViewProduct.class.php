<?php

/*
 * Get a Widget showing a product
 */
class Product_Widget_ViewProduct extends Widget_Form {

  public function __construct($product, $editable = FALSE) {
    var_dump($product);

    $this->classes[] = "clearfix";
    $this->AddCss(
      '#' . $this->id . '{ width:100%; position: relative; }
      .editField{ width:150px; }
      ');

    $this->SetTitle($product->title);
    /// Options
    $this->AddOption('Dashboard', 'Account/Dashboard');

    if($editable){
      /// Form
      $this->action = UriController::GetAbsolutePath('/Product/UpdateProduct' . $product->id);
      $this->method = 'POST';
    }

    // Remove following:
    // Title
    $cTitle = new Widget_Wrapper();
    $lTitle = new Widget_Label('Title ');
    $fTitle = new Widget_ClickEditField(isset($product->title) ? $product->title : '', !$editable);
    $fTitle->Title = 'Title';
    $fTitle->classes[] = 'editField';
    $cTitle->classes[] = 'hasALittleBitOfPadding';
    $cTitle->widgets += array($lTitle, $fTitle);
    $this->widgets[] = $cTitle;
  }
}
