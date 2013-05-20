<?php

class Purchase_Controller_Default extends CommonController {
	
	public function __construct() {
		$this->purchaseModel = CommonModel::GetModel('Purchase');
	}
	
  /*
   * View all purchases by you
   * @return Purchase_Widget_ViewPurchases
   */
  public function View($buyrent = "BR", $info = 'more') {
    $p = $this->purchaseModel->GetPurchases($_SESSION['username'], $_SESSION['token']->token, $buyrent, $info);    
    return new Purchase_Widget_ViewPurchases($p);
  }

  /*
   * Make purchases
   * @param $ids A comma seperated list of product ids
   * @return null
   */
  public function Purchase($ids) {
    try {
      $purchases = explode(",", $ids);
      array_walk($purchases, function(&$curr, $key) {
        $tmp = explode(":", $curr);
        if (count($tmp) != 2 ||
            strlen(trim($tmp[0])) == 0 ||
            strlen(trim($tmp[1])) == 0) {
          RentItError("Purchase malformed, ignored");
          $curr = array();
          return;
        }
        $curr = array(
          'product' => trim($tmp[1]),
          'purchased' => trim($tmp[0]),
        );
      });
      $this->purchaseModel->CreatePurchases($_SESSION['username'], array_filter($purchases), $_SESSION['token']->token);
      RentItSuccess(count($purchases)." product(s) purchased with success");
    } catch (PaymentRequiredException $e) {
      RentItError("You do not have enough credits for this purchase");
    } catch (ForbiddenException $e) {
      RentItError("You do not have permission to purchase those products");
    } catch (Exception $e) {
      RentItError("Server error");
    }
    RentItGoto();
  }

  /*
   * View a list of your purchases
   * @param $id Purchase id
   */
  public function GetPurchase($tId) {
    return Purchase_Widget_ViewPurchase();
  }

  /**
   * BuyRent widget. If either of buy or rent is specified, this assumes that both are entered.
   * @param $product The product to render buyrent for
   * @param $buy Optional buy to send, to avoid calling webservice multiple times
   * @param $rent Optional rent to send, to avoid calling webservice multiple times
   * @return Widget_Wrapper
   */
  public function BuyRent($product, $buy = null, $rent = null) {
    if (is_object($buy)) $buy = array($buy);
    if (is_object($rent)) $rent = array($rent);

    $container = new Widget_Wrapper();
    if (!isset($_SESSION['token'])) return $container;
    //Add styling
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

    //Whether or not to load from web service
    $doLoad = $buy == null && $rent == null;

    if ($doLoad && $product->price->buy == 0) $buy = false;
    else if ($doLoad) $buy = $pm->GetPurchaseByPid($_SESSION["username"], $_SESSION["token"]->token, $product->id, "B");
    if ($doLoad && $product->price->rent == 0) $rent = false;
    else if ($doLoad) $rent = $pm->GetPurchaseByPid($_SESSION["username"], $_SESSION["token"]->token, $product->id, "R");

    $cont = true;
    if ($buy !== false) {
      if ($buy == null)
        $b = new Purchase_Widget_Buy($product);
      else {
        $b = new Purchase_Widget_Bought(array_pop($buy));
        $cont = false;
      }
    } else $b = new Purchase_Widget_NotBuyable();
    $container->widgets[] = $b;
    if (!$cont) return $container;


    if ($rent !== false) {
      if ($rent == null)
        $r = new Purchase_Widget_Rent($product);
      else
        $r = new Purchase_Widget_Rentet(array_pop($rent));
    } else $r = new Purchase_Widget_NotRentable();
    $container->widgets[] = $r;
    return $container;
  }
}
