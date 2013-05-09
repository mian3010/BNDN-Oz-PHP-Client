<?php
class NotImplementedException extends BadMethodCallException
{}

function StandardAutoload($class) {
  //Replace underscores with slashes, to find class file path
  $classPath = str_replace("_", "/", $class);

  //If no path is specified, default to Common/Controller
  if (!strpos($classPath, "/")) $classPath = "Modules/Common/Controller/".$classPath.".class.php";

  //Else look in modules folder
  else $classPath = "Modules/".$classPath.".class.php";
  if (file_exists($classPath)) {
    //Include the file
    require_once($classPath);
    return TRUE;
  }

  //Class not found
  return FALSE;
}
spl_autoload_register("StandardAutoload");

//Include common files, that cannot be fould via autoload
require_once("Modules/Common/Model/CommonModel.class.php");
require_once("Modules/Common/View/CommonView.class.php");
require_once("Modules/Common/Widget/Widget.class.php");
require_once("Modules/Common/Widget/WidgetContainer.class.php");

//Widget should register own autoloader
Widget::register();
