<?php

class Testing_Base extends PHPUnit_Framework_TestCase {
  public function __construct() {
    set_include_path(get_include_path() . PATH_SEPARATOR . realpath('..'));
    require_once('Includes/Common.php');
  }
  public function testDummy() {

  }
}
