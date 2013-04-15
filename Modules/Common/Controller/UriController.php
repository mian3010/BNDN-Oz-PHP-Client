<?php

class UriController {
  public static function parseUri() {
    $args = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
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
}
