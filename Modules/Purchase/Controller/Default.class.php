<?php

class Purchase_Controller_Default extends CommonController {
	
	public function __construct() {
		$this->purchaseModel = CommonModel::GetModel('Purchase');
	}
	
  /*
   * Get a list of Purchases?
   */
  public function GetPurchases($buyrent = "BR", $info = 'more') {
    return $this->purchaseModel->GetPurchases($_SESSION['username'], $_SESSION['token'], $buyrent, $info);
  }

  /*
   * Make purchases
   * @param $ids A comma seperated list of product ids
   */
  public function CreatePurchases($ids) {
  	$pIds = explode(",", $ids);
    return $this->purchaseModel->CreatePurchases($_SESSION['username'], $pIds, $_SESSION['token']);
  }

  /*
   * Get a single purchase
   * @param $id Purchase id
   */
  public function GetPurchase($tId) {
    return $this->purchaseModel->GetPurchase($_SESSION['username'], $tId, $_SESSION['token']);
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
