<?php
/*
 * Widget for an accounts dasboard
 */
class Account_Widget_AccountDashboard extends Widget_Wrapper {
  public function __construct($purchases, $products, $buys, $rents) {
    //Setup basic configuration
    $this->SetTitle("Dashboard");
    $this->AddOption("View profile", "Account/View/".$_SESSION['username']);

    //Setup buys part
    $brw = new Widget_Wrapper();
    $bw = new Widget_Wrapper();
    $bw->wrapperTitle = "Buys";
    $bw->classes[] = 'hasLargeTitle';
    $bw->classes[] = 'hasSpecialTitle';
    foreach ($buys as $buy) {
      $bw->widgets[] = new Product_Widget_SmallViewProduct($products[$buy]["product"], $products[$buy]["buy"], $products[$buy]["rent"]);
    }
    //Setup rents part
    $rw = new Widget_Wrapper();
    $rw->wrapperTitle = "Rents";
    $rw->classes[] = 'hasLargeTitle';
    $rw->classes[] = 'hasSpecialTitle';
    foreach ($rents as $rent) {
      $rw->widgets[] = new Product_Widget_SmallViewProduct($products[$rent]["product"], $products[$rent]["buy"], $products[$rent]["rent"]);
    }

    //Setup purchases part
    $sl = new Widget_Slider();
    $l = new Widget_Link('Purchase/View');
    $ll = new Widget_Label('View purchases');
    $l->classes[] = 'more-link';
    $l->widgets[] = $ll;
    $sl->widgets[] = $l;
    $sl->SlideRight();
    foreach ($purchases as $purchase) {
      $sl->widgets[] = new Purchase_Widget_SmallViewPurchase($purchase);
    }

    //Add everything to us
    $brw->widgets[] = $sl;
    $brw->widgets[] = $bw;
    $brw->widgets[] = $rw;
    $this->widgets[] = $brw;
  }
}
