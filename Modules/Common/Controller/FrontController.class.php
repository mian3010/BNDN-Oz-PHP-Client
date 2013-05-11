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
    $controllerClass = $module."_Controller_Default";
    if (!class_exists($controllerClass)) throw new InvalidArgumentException("Module not found!");

    //Instantiate widget
    $controller = new $controllerClass();
    $container = call_user_func_array(array($controller, $method), UriController::RestOfArgs(2));

    //Create CommonView for rendering
    $view = new CommonView($container);

    //If nowrap is set, only render container
    if (isset($_GET['nowrap'])) echo $view->RenderContainer();
    
    //Else call render method, and output.
    else echo $view->Render();
  }
}
