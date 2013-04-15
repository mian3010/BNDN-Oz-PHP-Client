<?php

class FrontController {
  public function __construct() {
    require_once("Modules/Common/Model/CommonModel.php");
    require_once("Modules/Common/View/CommonView.php");
    spl_autoload_register("FrontController::__autoload");
  }
  public function init() {
    //Parse the URI to GET variable
    UriController::parseUri();
    //Get the module and method to call
    $module = $_GET[0]."_View_Default";
    $method = $_GET[1];
    //Send the rest of URL as arguments to method
    $args = UriController::restOfArgs(2);
    //Check if class exists
    if (!class_exists($module)) throw new InvalidArgumentException("Module not found!");
    //Create instance of class
    $moduleView = new $module();
    //Check if method exists
    if (!method_exists($moduleView, $method)) throw new InvalidArgumentException("Method not found!");
    //Call method
    $container = call_user_func_array(array($moduleView, $method), $args);
    //Has call failed?
    if ($container == FALSE) throw new Exception("Something went wrong in calling view method");
    //Call render
    echo call_user_func_array(array($moduleView, "render"), array($container));
  }
  public static function __autoload($class) {
    $classPath = str_replace("_", "/", $class);
    if (!strpos($classPath, "/")) $classPath = "Common/Controller/".$classPath;
    $classPath = "Modules/".$classPath.".php";
    if (file_exists($classPath)) {
      require_once($classPath);
      return TRUE;
    }
    return FALSE;
  }
}
