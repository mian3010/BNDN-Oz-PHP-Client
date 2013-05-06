<?php

abstract class CommonView {
  /*
   * Parse arguments to object properties
   * Render depends on these arguments
   * @param $args An array containing all the arguments from the url
   */
  public function __construct($arg) {
    $this->arg = $arg; //
    foreach ($_GET as $key => $value) $this->$key = $value;
  }

  /*
   * Render the view
   * @return A renderable widget
   */
  abstract function render();
}
