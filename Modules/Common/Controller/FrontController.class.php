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
    $widgetClass = $module."_Widget_".$method;
    if (!class_exists($widgetClass)) throw new InvalidArgumentException("Module not found!");

    //Instantiate widget
    $container = $widgetClass();

    //Create CommonView for rendering
    $view = new CommonView($container);

    //If nowrap is set, only render container
    if (isset($_GET['nowrap'])) echo $view->renderContainer();
    
    //Else call render method, and output.
    else echo $view->render();
  }
}
