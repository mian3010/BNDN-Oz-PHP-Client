<?php
/*
 * Widget for an accounts dasboard
 */
class Account_Widget_AccountDashboard extends Widget_Wrapper {
  public function __construct() {
    $wd = new Widget_ThreePartButton("cache", "Buy", "20", "C");
    $this->widgets[] = $wd;
  }
}
