<?php

class Testing_Base extends PHPUnit_Framework_TestCase {
  public function __construct() {
    set_include_path(get_include_path() . PATH_SEPARATOR . realpath('..'));
    require_once('Includes/Common.php');
  }

  /*
   * Helper method for returning an inaccesible method, and being able to call 
   * it
   */  
  protected function GetMethod($class, $method) {
    $class = new ReflectionClass($class);
    $method = $class->getMethod($method);
    $method->setAccessible(true);
    return $method;
  }
  
  public function testDummy() {
    $this->assertTrue(true);
  } 
}
