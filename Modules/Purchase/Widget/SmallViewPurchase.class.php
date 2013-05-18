<?php
/**
 * Widget containing a small view of a purchase
 */
class Purchase_Widget_SmallViewPurchase extends Widget_Wrapper {
  public function __construct($purchase) {
    //Styling
    $this->classes[] = 'small-purchase';
    $css = <<<CSS
      .small-purchase {
        width: 463px;
        height: 100px;
        position: relative;
        margin: 20px;
      }
      .small-purchase-inner {
        padding: 15px;
        margin: 0 20px;
        position: absolute;
        top: 15px;
        bottom: 0;
        left: 0;
        right: 0;
      }
CSS;
    $this->AddCss($css);
    $w = new Widget_Wrapper();
    $w->classes[] = "small-purchase-inner";

    //Title
    if ($purchase->type == "B") $title = "Buy";
    if ($purchase->type == "R") $title = "Rent";
    $this->wrapperTitle = "Type: ".$title;

    //Purchased date
    $plbw = new Widget_Wrapper();
    $plb = new Widget_Label("Purchased: ");
    $pdb = new Widget_Date($purchase->purchased);
    $plbw->widgets = array($plb, $pdb);

    //Purchase expire
    if ($purchase->type == "R") $expDate = new Widget_Date($purchase->expires);
    else $expDate = new Widget_Label("Never");

    //Purchase expire
    $plrw = new Widget_Wrapper();
    $plr = new Widget_Label("Expires: ");
    $pdr = $expDate;
    $plrw->widgets = array($plr, $pdr);

    //Credits paid
    $plrpw = new Widget_Wrapper();
    $pcrp = new Widget_ThreePartButton("", "Paid", $purchase->paid, "C");
    $pcrp->disabled = true;
    $plrpw->widgets = array($pcrp);

    //Add everything
    $w->widgets[] = $plbw;
    $w->widgets[] = $plrw;
    $w->widgets[] = $plrpw;

    $this->widgets[] = $w;
  }
}
