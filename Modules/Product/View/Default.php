<?php

class Product_View_Default extends CommonView {
  public function ViewProduct($id) {
    var_dump($id);
    return new StdClass();
  }
}
