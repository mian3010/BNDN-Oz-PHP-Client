<?php

class FrontController {
  public function __construct() {
    require_once("Modules/Common/Controller/CommonController.php");
    require_once("Modules/Common/Model/CommonModel.php");
    require_once("Modules/Common/View/CommonView.php");
    spl_autoload_register("FrontController::__autoload");
  }
  public function init() {

    $ProductView = new Product_View_Default();
    echo $ProductView->render();
  }
  public static function __autoload($class) {
    $classPath = str_replace("_", "/", $class);
    require_once("Modules/".$classPath.".php");
  }
}
