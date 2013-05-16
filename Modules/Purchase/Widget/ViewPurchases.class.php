<?php

class Purchase_Widget_ViewPurchases extends Widget_Table {
  public function __construct($purchases) {
    $css = <<<CSS
      .greatTable{
        border-collapse: separate; 
        border-spacing: 15px;
        border-style:solid;
        border-width: 2px;
        width: 100%;
      }
      .greatTable thead {
        outline: 1px solid #fff;
      }
CSS;
    $this->AddCss($css);
    $this->SetTitle("Purchases");
    $this->classes[] = 'greatTable';
    
    // Make header;
    $hr = new Widget_TableRow();
    $hr->AutoCreateMultiCells("Purchase ID,Purchase date,Expire date,Price,Type");
    
    $head = new Widget_TableHeader();
    $head->AddRow($hr);
    $this->AddHeader($head);
    
    // content
    if($purchases != null) {
      foreach ($purchases as $p) {
        $this->AddRow($this->createRowFromPurchase($p));
      }
    }
  }
    
  private function createRowFromPurchase($purchase) {
    $r = new Widget_TableRow();
    $r->AutoCreateCell($purchase->id);
    $r->AutoCreateCell($purchase->purchased);
    $r->AutoCreateCell(isset($purchase->expires) ? $purchase->expires : "Never");
    $r->AutoCreateCell($purchase->paid);
    $r->AutoCreateCell($purchase->type);
    return $r;
  }
}
