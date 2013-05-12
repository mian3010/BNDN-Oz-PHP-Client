<?php

class Purchase_Controller_Default extends CommonController {
  /*
   * Get a list of Purchases?
   */
  public function GetPurchases() {
    throw new NotImplementedException();
  }

  /*
   * Make purchases
   * @param $ids Array of product ids
   */
  public function CreatePurchases($ids) {
    throw new NotImplementedException();
  }

  /*
   * Get a single purchase?
   * @param $id Purchase id
   */
  public function GetPurchase($id) {
    throw new NotImplementedException();
  }

  public function BuyRent($product) {
    //Testing
    $prm = CommonModel::GetModel("Product");
    $product = $prm->GetProduct(8, $_SESSION['token']->token);

    $container = new Widget_Wrapper();
    $pm = CommonModel::GetModel("Purchase");

    $bPurchases = $pm->GetPurchases($_SESSION['username'], $_SESSION['token']->token, "B");
    $bought = null;
    foreach ($bPurchases as $bPurchase)
      if ($bPurchase->product == $product->id) {
        $bought = $bPurchase;
        break;
      }
    
    $rPurchases = $pm->GetPurchases($_SESSION['username'], $_SESSION['token']->token, "R");
    $rentet = null;
    foreach ($rPurchases as $rPurchase)
      if ($rPurchase->product == $product->id) {
        $bought = $rPurchase;
        break;
      }

    if ($bought == null)
      $b = new Purchase_Widget_Buy($product->price->buy);
    else
      $b = new Purchase_Widget_Bought($bought);
    if ($bought == null && $rentet = null)
      $r = new Purchase_Widget_Rent($product->price->buy);
    else if ($bought == null)
      $r = new Purchase_Widget_Rentet($rentet);
    else
      $r = null;

    $container->widgets[] = $b;
    if ($r != null) $container->widgets[] = $r;

    return $container;
  }
}
