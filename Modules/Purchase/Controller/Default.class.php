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
    $product = $prm->GetProduct(12, $_SESSION['token']->token);

    $container = new Widget_Wrapper();
    $pm = CommonModel::GetModel("Purchase");

    $bPurchases = $pm->GetPurchases($_SESSION['username'], $_SESSION['token']->token, "B");
    if ($product->price->buy > 0) {
      $bought = null;
      foreach ($bPurchases as $bPurchase)
        if ($bPurchase->product == $product->id) {
          $bought = $bPurchase;
        break;
        }
    } else $bought = false;
  
    $rPurchases = $pm->GetPurchases($_SESSION['username'], $_SESSION['token']->token, "R");
    if ($product->price->rent > 0) {
      $rentet = null;
      foreach ($rPurchases as $rPurchase)
        if ($rPurchase->product == $product->id && strtotime($rPurchase->expires) > time()) {
          $rentet = $rPurchase;
          break;
        }
    } else $rentet = false;

    if ($bought !== false) {
      if ($bought == null)
        $b = new Purchase_Widget_Buy($product->price->buy);
      else
        $b = new Purchase_Widget_Bought($bought);
    } else $b = new Purchase_Widget_NotBuyable();
    $container->widgets[] = $b;
    if ($bought != null) return $container;


    if ($rentet !== false) {
      if ($bought == null && $rentet == null)
        $r = new Purchase_Widget_Rent($product->price->rent);
      else if ($bought == null)
        $r = new Purchase_Widget_Rentet($rentet);
    } else $r = new Purchase_Widget_NotRentable();
    $container->widgets[] = $r;
    return $container;
  }
}
