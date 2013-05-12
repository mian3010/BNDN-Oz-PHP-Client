<?php
/*
 * Widget for an accounts dasboard
 */
class Account_Widget_AccountDashboard extends Widget_Wrapper {
  public function __construct() {
    $wd = new Widget_Image("http://www.afh.com/web/gif89a/sample2.gif");
    $wd->height = 100;
    $wd->width = 120;
    $this->widgets[] = $wd;
  }
}
