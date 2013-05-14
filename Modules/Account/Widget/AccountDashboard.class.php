<?php
/*
 * Widget for an accounts dasboard
 */
class Account_Widget_AccountDashboard extends Widget_Wrapper {
  public function __construct($purchases, $products, $buys, $rents) {
    $brw = new Widget_Wrapper();
    $bw = new Widget_Wrapper();
    $bw->wrapperTitle = "Buys";
    foreach ($buys as $buy) {
      $bw->widgets[] = new Product_Widget_SmallViewProduct($products[$buy]["product"], $products[$buy]["buy"], $products[$buy]["rent"]);
    }
    $rw = new Widget_Wrapper();
    $rw->wrapperTitle = "Rents";
    foreach ($rents as $rent) {
      $rw->widgets[] = new Product_Widget_SmallViewProduct($products[$rent]["product"], $products[$rent]["buy"], $products[$rent]["rent"]);
    }
    $brw->widgets[] = $bw;
    $brw->widgets[] = $rw;
    $this->widgets[] = $brw;
/*
    var_dump($productsRentet);

    var_dump($purchases);*/
  }
}
