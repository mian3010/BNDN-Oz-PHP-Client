<?php

abstract class Widget {
  public $classes = array(); // Array of HTML classes
  protected $atrbs = array();

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

  public function __set($k, $v){
    $this->atrbs[$k] = $v;
  }

  public function __get($k) {
    return $this->atrbs[$k];
  }

  protected function GetAttributes(){
    $this->atrbs['id'] = $this->id;
    $this->atrbs['class'] = $this->GetClasses();
    $atrb = '';
    foreach ($this->atrbs as $key => $value) $atrb .= $key . '="' . $value . '" ';
    return $atrb;
  }

  protected function GetClasses() {
    $classesStr = '';
    foreach ($this->classes as $c) $classesStr .= $c.' ';
    return trim($classesStr);
  }

  public abstract function ToHtml();
}
