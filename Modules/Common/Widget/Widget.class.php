<?php

abstract class Widget {
  public static function register() {
    spl_autoload_register("Widget::WidgetAutoload");
  }
  public static function WidgetAutoload($class) {
    $prefix = "Widget_";
    
    //Should the class being loaded be handled by us?
    if (strpos($class, $prefix) == 0) {
      
      //Path to class file
      $classFile = "Modules/Common/Widget/".substr($class, strlen($prefix)).".class.php";
      if (file_exists($classFile)) {
        //Include class file
        require_once($classFile);
        return TRUE;
      }
    }
    //Class is not part of widgets
    return FALSE;
  }
  
  abstract function ToHtml();
}
