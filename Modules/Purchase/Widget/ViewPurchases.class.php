<?php

class Purchase_Widget_ViewPurchases extends Widget_Container {
    private $purchases = null;
    
  public function __construct($purchases) {
    //print_r($purchases);
    $this->purchases = $purchases;
    $this->SetTitle("Purchases");
  }
  
  public function ToHtml() {
    $t = new Widget_Table();
    $t->class = 'greatTable';
    
    // Make header;
    $hr = new Widget_TableRow();
    $hr->AutoCreateMultiCells("Purchase ID,PDate,ExpDate,Price,Type");
    
    $head = new Widget_TableHeader();
    $head->AddRow($hr);
    $t->AddHeader($head);
    
    // content
    if($this->purchases != null) {
      foreach ($this->purchases as $p) {
        $t->AddRow($this->createRowFromPurchase($p));
      }
    }
    
    return $t->ToHtml();
  }
  
  public function GetCss() {
    $css = <<<CSS
      .greatTable{
        border-collapse: none; 
        border-spacing: 5px;
      }
CSS;
    $this->AddCss($css);
    return parent::GetCss();
  }
  
  private function createRowFromPurchase($purchase) {
    $r = new Widget_TableRow();
    $r->AutoCreateCell($purchase->id);
    $r->AutoCreateCell($purchase->purchased);
    $r->AutoCreateCell($purchase->expires);
    $r->AutoCreateCell($purchase->paid);
    $r->AutoCreateCell($purchase->type);
    return $r;
  }
}