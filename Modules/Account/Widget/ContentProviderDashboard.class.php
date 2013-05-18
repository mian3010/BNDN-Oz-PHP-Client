<?php
/*
 * Widget for a content providers dashboard
 */
class Account_Widget_ContentProviderDashboard extends Widget_Wrapper {
  public function __construct($published, $unpublished) {
    //Setup basic configuration
    $this->SetTitle("Dashboard");
    $this->AddOption("View profile", "Account/View/".$_SESSION['username']);

    //Setup published products part
    $pw = new Widget_Wrapper();
    $pw->wrapperTitle = "Published products";
    $pw->classes[] = 'hasLargeTitle';
    $pw->classes[] = 'hasSpecialTitle';
    foreach ($published as $product) {
      $pw->widgets[] = new Product_Widget_SmallViewProduct($product);
    }

    //Setup unpublished products parts
    $uw = new Widget_Slider();
    $uw->SlideRight();
    $uw->classes[] = 'right';
    $uw->wrapperTitle = "Unpublished products";
    $uw->classes[] = 'hasLargeTitle';
    $uw->classes[] = 'hasSpecialTitle';
    $uw->style = "width: 475px; padding: 20px;";
    foreach ($unpublished as $product) {
      $widget = new Product_Widget_SmallViewProduct($product);
      $uw->widgets[] = $widget;
    }

    //Add parts to us
    $this->widgets[] = $uw;
    $this->widgets[] = $pw;
  }
}
