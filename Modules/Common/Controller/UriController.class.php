<?php
/**
 * Handles the URI. Main responsibility is to parse URI to get variable.
 */
class UriController {
  /**
   * Parse the URI to GET variable
   * @return null
   */
  public static function parseUri() {
    $args = explode("/", trim($_SERVER['REQUEST_URI'], "/"));

    //Is there index.php in uri?
    $key = array_search("index.php", $args);
    //If there is, dont parse that and preceding uri to get
    //Could happen is mod_rewrite is disabled
    if($key !== false)
      $args = array_slice($args, $key+1);

    //Parse it
    array_walk($args, function($v, $k) {
      $_GET[$k] = $v;
    });
  }
  /**
   * Return the rest of arguments starting from a position
   * @param $start The index of the first element to return
   * @return Array containing the rest of arguments
   */
  public static function restOfArgs($start) {
    $rest = array();
    $i = $start;
    while (isset($_GET[$i])) {
      $rest[$i] = $_GET[$i++];
    }
    return $rest;
  }
  /**
   * Get the base path of the application. This is used if mod_rewrite is not enabled, or server is not a virtual-host
   * @param $incAppBase Whether or not to include the base of the application
   * @return The base path
   */
  public static function GetBasePath($inclAppBase=false) {
  	$args = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
    	$key = array_search("index.php", $args);
    	if($key === false) return '/';
    	else return '/' . implode('/', array_slice($args, 0, $key+$inclAppBase)) . '/';
  }
  /**
   * Get the absolute path from a relative path
   * @param $relative The relative path
   * @return The absolute path
   */ 
  public static function GetAbsolutePath($relative) {
    //Trim magic is used to make sure that only one slash is at either end
    return "/".trim(self::GetBasePath(true) . trim($relative, "/"), "/").'/';
  }
}
