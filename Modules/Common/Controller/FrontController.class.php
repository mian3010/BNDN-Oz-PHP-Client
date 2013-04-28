<?php

class FrontController {
  public function __construct() {
    //Include common files, that cannot be fould via autoload
    require_once("Modules/Common/Model/CommonModel.class.php");
    require_once("Modules/Common/View/CommonView.class.php");
    require_once("Modules/Common/Widget/Widget.class.php");
    //Widget should register own autoloader
    Widget::register();
  }
  public function init() {
    //Parse the URI to GET variable
    UriController::parseUri();

    //Get the module and method to call
    $module = $_GET[0];
    $view = $module."_View_".$_GET[1];

    //Send the rest of URL as arguments to method
    $arg = implode("/", UriController::restOfArgs(2));

    //Check if class exists
    if (!class_exists($view)) throw new InvalidArgumentException("View not found!");

    //Create instance of class
    $moduleView = new $view($arg);

    //Call render method
    $container = $moduleView->render();

    //Has call failed?
    if (!is_subclass_of($container, "Widget")) throw new Exception("Something went wrong in rendering view");

    //Output container html
    echo $container->toHtml();
  }
}
