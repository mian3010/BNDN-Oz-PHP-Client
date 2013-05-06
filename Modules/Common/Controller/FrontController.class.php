<?php

class FrontController {
  public function __construct() {
    //Include common files, that cannot be fould via autoload
    require_once("Modules/Common/Model/CommonModel.class.php");
    require_once("Modules/Common/View/CommonView.class.php");
    require_once("Modules/Common/Widget/Widget.class.php");
    require_once("Modules/Common/Widget/WidgetContainer.class.php");
    //Widget should register own autoloader
    Widget::register();
  }
  public function init() {
    //Parse the URI to GET variable
    UriController::parseUri();
    
    $module = $_GET[0];
    $method = $_GET[1];

    //Get the container containing our view
    
    //Check if class exists
    $controller = $module."_Controller_Default";
    if (!class_exists($controller)) throw new InvalidArgumentException("Module not found!");
    if (!method_exists($controller, $method)) throw new InvalidArgumentException("View not found!");

    //Call the controller static method
    $container = call_user_func_array($controller.'::'.$method, array(UriController::restOfArgs(2)));

    //Create CommonView for rendering
    $view = new CommonView($container);

    //If nowrap is set, only render container
    if (isset($_GET['nowrap'])) echo $view->renderContainer();
    //Else call render method, and output.
    else echo $view->render();
  }
}
