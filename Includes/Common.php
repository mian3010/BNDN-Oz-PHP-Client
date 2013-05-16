<?php

function StandardAutoload($class) {
  //Replace underscores with slashes, to find class file path
  $classPath = str_replace("_", "/", $class);

  //If no path is specified, default to Common/Controller
  if (!strpos($classPath, "/")) $classPath = "Modules/Common/Controller/".$classPath.".class.php";

  //Else look in modules folder
  else $classPath = "Modules/".$classPath.".class.php";

  //Include the file
  if (@include_once($classPath)) return TRUE;

  //Class not found
  return FALSE;
}
spl_autoload_register("StandardAutoload");

//Include common files, that cannot be fould via autoload
require_once("Exceptions.php");
require_once("Modules/Common/Model/CommonModel.class.php");
require_once("Modules/Common/View/CommonView.class.php");
require_once("Modules/Common/Widget/Widget.class.php");
require_once("Modules/Common/Widget/WidgetContainer.class.php");
require_once("Exceptions.php");
require_once("Modules/Common/Model/WebService.class.php");
require_once("Modules/Common/Model/JsonParser.class.php");

//Widget should register own autoloader
Widget::register();

function RentItGoto($module = '', $method = '', $args = array()) {
  if($module == '')
    RentItGoto('Product', 'ViewAll');
  header("Location: ".UriController::GetAbsolutePath("/$module/$method/".implode("/", $args)));
  exit;
}

function RentItError($message) {
  if (!isset($_SESSION['errors'])) $_SESSION['errors'] = array();
	
	if($_SESSION['errors'] == null){
		
		$_SESSION['errors'] = array();
	}
	
	$_SESSION['errors'][] = $message;
}

function RentItInfo($message) {
  if (!isset($_SESSION['info'])) $_SESSION['info'] = array();

	if($_SESSION['info'] == null){
	
		$_SESSION['info'] = array();
	}
	
	$_SESSION['info'][] = $message;
}


function RentItSuccess($message) {
  if (!isset($_SESSION['successes'])) $_SESSION['successes'] = array();

	if($_SESSION['successes'] == null){
	
		$_SESSION['successes'] = array();
	}
	
	$_SESSION['successes'][] = $message;
}
