<?php
/**
 * Controller for displaying a page.
 * Handles URI and calls the right controllers method based on it
 */
class FrontController {
  /**
   * Initialize the page
   * @return null
   */
  public function init() {
    try {
      session_start();
      //Parse the URI to GET variable
      UriController::parseUri();

      //Get the module and method from URI
      $module = $_GET[0];
      $method = $_GET[1];
      //If no module is specified goto default page
      if (empty($module)) throw new InvalidArgumentException("Module not specified");
      if (empty($method)) throw new InvalidArgumentException("Method not specified");
      
      //Check if class exists
      $controllerClass = $module."_Controller_Default";
      if (!class_exists($controllerClass)) throw new InvalidArgumentException("Module not found: ".$module." (".$controllerClass.")");

      //Instantiate widget
      $controller = new $controllerClass();
      if (!method_exists($controller, $method)) throw new InvalidArgumentException("Method ".$method." not found in module: ".$module." (".$controllerClass.")");
      $container = call_user_func_array(array($controller, $method), UriController::RestOfArgs(2));

      //Create CommonView for rendering
      $view = new CommonView($container);

      //If nowrap is set, only render container
      if (isset($_GET['nowrap'])) echo $view->RenderContainer();
      
      //Else call render method, and output.
      else echo $view->Render();
    } catch (InvalidArgumentException $e) {
      //Go to standard page
      RentItGoto();
    } catch (Exception $e) {
      //Set error
      RentItError("Server error");
      //Go to standard page
      RentItGoto();
    }
  }
}
