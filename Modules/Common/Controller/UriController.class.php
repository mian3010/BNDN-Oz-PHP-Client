<?php

class UriController {
  public static function parseUri() {
    $args = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
    
    $key = array_search("index.php", $args);
    if($key !== false)
      $args = array_slice($args, $key+1); // In case mod_rewrite is disabled and/or the application is not the document base
    
    array_walk($args, function($v, $k) {
      $_GET[$k] = $v;
    });
  }
  public static function restOfArgs($start) {
    $rest = array();
    $i = $start;
    while (isset($_GET[$i])) {
      $rest[$i] = $_GET[$i++];
    }
    return $rest;
  }
  public static function GetBasePath($inclAppBase=false) {
  
  	$args = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
    
    	$key = array_search("index.php", $args);
    	if($key === false) return '/';
    	else return '/' . implode('/', array_slice($args, 0, $key+$inclAppBase)) . '/';
  }
  public static function GetAbsolutePath($relative) {
    return "/".trim(self::GetBasePath(true).$relative, "/").'/';
  }
}
