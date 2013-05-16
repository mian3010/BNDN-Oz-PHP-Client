<?php

/*
 * Get a Widget showing a product
 */
class Product_Widget_ViewProduct extends Widget_Form {

  public function __construct($product, $editable = FALSE) {
    $pc = new Product_Controller_Default();
    $puc = new Purchase_Controller_Default();

    $this->classes[] = "clearfix";
    $this->AddCss(
      '#' . $this->id . '{ width:100%; position: relative; }
      .editField{ width:150px; }
      ');

    $this->SetTitle($product->title);
    /// Options
    $this->AddOption('Dashboard', 'Account/Dashboard');

    $wrapper = new Widget_Wrapper();

    if($editable){
      /// Form
      $this->action = UriController::GetAbsolutePath('/Product/UpdateProduct' . $product->id);
      $this->method = 'POST';

      $cTitle = new Widget_Wrapper();
      $cTitle->wrapperTitle = 'Title';
      $fTitle = new Widget_ClickEditField(isset($product->title) ? $product->title : '', !$editable);
      $fTitle->name = 'title';
      $cTitle->classes[] = 'hasALittleBitOfPadding';
      $cTitle->widgets[] = $fTitle;
      $wrapper->widgets[] = $cTitle;
    }

    $cAbout = new Widget_Wrapper();
    $fAbout = new Widget_ClickEditField(isset($product->description) ? $product->description : '', !$editable);
    $fAbout->name = 'description';
    $cAbout->wrapperTitle = 'Description';
    $cAbout->classes[] = 'hasALittleBitOfPadding';
    $cAbout->widgets[] = $fAbout;

    $rightWrapper = new Widget_Wrapper();
    $rightWrapper->classes[] = 'right';

    // Thumb
    $thumb = new Product_Widget_ViewThumbnail($product->id);
    $thumb->width = 200;
    $thumb->height = 200;
    $thumb->classes[] = 'hasALittleBitOfPadding';
    $rightWrapper->widgets[] = $thumb;

    // Type
    $cType = new Widget_Wrapper();
    //TODO Make this a link when Browse supports it
    $fType = new Widget_ClickEditField(isset($product->type) ? ucfirst($product->type) : '', !$editable);
    $fType->classes[] = 'editField';
    $cType->classes[] = 'hasALittleBitOfPadding';
    $cType->widgets[] = $fType;
    $rightWrapper->widgets[] = $cType;

    if($editable){
      // Published
      $cPublished = new Widget_Wrapper();
      $lPublished = new Widget_Label('Published ');
      $fPublished = new Widget_CheckBox($product->published);
      $fPublished->name = 'published';
      $cPublished->classes[] = 'hasALittleBitOfPadding';
      $cPublished->widgets += array($lPublished, $fPublished);
      $rightWrapper->widgets[] = $cPublished;
    }

    // Owner
    $cOwner = new Widget_Wrapper();
    $lOwner = new Widget_Label('Owner ');
    if($editable){
      $fOwner = new Widget_ClickEditField(isset($product->owner) ? $product->owner : '', !$editable);
      $fOwner->classes[] = 'editField';
    } else {
      $fOwner = new Widget_Link('/Account/View/' . $product->owner);
      $fLabel = new Widget_Label($product->owner);
      $fOwner->widgets[] = $fLabel;
    }
    $cOwner->classes[] = 'hasALittleBitOfPadding';
    $cOwner->widgets += array($lOwner, $fOwner);
    $rightWrapper->widgets[] = $cOwner;

    if($editable){
      //Submit button
      $s = new Widget_Button("Save changes");
      $s->classes[] = 'hasALittleBitOfPadding';
      $rightWrapper->widgets[] = $s;
    }

    // Rating widget
    //$rightWrapper->widgets[] = $pc->ViewRating($product->id);

    // Buy/Rent widget
    $br = $puc->BuyRent($product);
    $rightWrapper->widgets[] = $br;

    $wrapper->widgets[] = $rightWrapper;
    $wrapper->widgets[] = $cAbout;
    $this->widgets[] = $wrapper;
  }
}
