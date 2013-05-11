<?php

class FrontController {
  public function __construct() {
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
    $container = new $widgetClass();

    //Create CommonView for rendering
    $view = new CommonView($container);

    //If nowrap is set, only render container
    if (isset($_GET['nowrap'])) echo $view->renderContainer();
    
    //Else call render method, and output.
    else echo $view->render();
  }
}
