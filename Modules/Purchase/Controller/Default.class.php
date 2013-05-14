<?php

class Purchase_Controller_Default extends CommonController {
	
	public function __construct() {
		$this->purchaseModel = CommonModel::GetModel('Purchase');
	}
	
  /*
   * Get a list of Purchases?
   */
  public function GetPurchases($buyrent = "BR", $info = 'more') {
    $p = $this->purchaseModel->GetPurchases($_SESSION['username'], $_SESSION['token']->token, $buyrent, $info);    
    return new Purchase_Widget_ViewPurchases($p);
  }

  /*
   * Make purchases
   * @param $ids A comma seperated list of product ids
   */
  public function CreatePurchases($ids) {
  	//$pIds = explode(",", $ids);
    //return $this->purchaseModel->CreatePurchases($_SESSION['username'], $pIds, $_SESSION['token']);
    //return Purchase_Widget_
  }

  /*
   * Get a single purchase
   * @param $id Purchase id
   */
  public function GetPurchase($tId) {
    //return $this->purchaseModel->GetPurchase($_SESSION['username'], $tId, $_SESSION['token']);
    return Purchase_Widget_ViewPurchase();
  }

  public function BuyRent($product, $buy = null, $rent = null) {
    $container = new Widget_Wrapper();
    if (!isset($_SESSION['token'])) return $container;
    $container->classes[] = 'buy-rent';
    $css = <<<CSS
      .buy-rent {
        width: 150px;
        height: 100px;
      }
      .buy-rent > div {
        text-align: center;
        margin: 15px 0;
      }
CSS;
    $container->AddCss($css);
    $pm = $this->purchaseModel;

    $doLoad = $buy == null && $rent == null;

    if ($doLoad && $product->price->buy == 0) $buy = false;
    else if ($doLoad) $buy = $pm->GetPurchaseByPid($_SESSION["username"], $_SESSION["token"]->token, $product->id);
    if ($doLoad && $product->price->rent == 0) $rent = false;
    else if ($doLoad) $rent = $pm->GetPurchaseByPid($_SESSION["username"], $_SESSION["token"]->token, $product->id);

    if ($buy !== false) {
      if ($buy == null)
        $b = new Purchase_Widget_Buy($product->price->buy);
      else
        $b = new Purchase_Widget_Bought($buy);
    } else $b = new Purchase_Widget_NotBuyable();
    $container->widgets[] = $b;
    if ($buy != null) return $container;


    if ($rent !== false) {
      if ($rent == null)
        $r = new Purchase_Widget_Rent($product->price->rent);
      else
        $r = new Purchase_Widget_Rentet($rent);
    } else $r = new Purchase_Widget_NotRentable();
    $container->widgets[] = $r;
    return $container;
  }
}
