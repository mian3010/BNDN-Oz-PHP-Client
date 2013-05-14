<?php
/*
 * Widget for an accounts dasboard
 */
class Account_Widget_AccountDashboard extends Widget_Wrapper {
  public function __construct() {
    $pm = CommonModel::GetModel("Product");
    $prod1 = $pm->GetProduct(7);
    $prod2 = $pm->GetProduct(8);
    $this->widgets[] = new Product_Widget_SmallViewProduct($prod1);
    $this->widgets[] = new Product_Widget_SmallViewProduct($prod2);
  }
}
