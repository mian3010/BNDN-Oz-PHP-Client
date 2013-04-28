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
