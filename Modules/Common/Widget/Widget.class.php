<?php
/**
 * The base class for all widgets
 */
abstract class Widget {
  public $classes = array(); // Array of HTML classes
  protected $atrbs = array();
  private $js = array();
  private $css = array();
  private $jsFiles = array();
  private $cssFiles = array();
  private $title = '';
  private $options = array();

  /**
   * Register our own autoloader for loading common widgets
   * @return null
   */
  public static function register() {
    spl_autoload_register("Widget::WidgetAutoload");
  }
  /**
   * Autoloader to load common widgets
   * @return bool telling if class was loaded
   */
  public static function WidgetAutoload($class) {
    $prefix = "Widget_";
    
    //Should the class being loaded be handled by us?
    if (strpos($class, $prefix) == 0) {

      //Path to class file
      $classFile = "Modules/Common/Widget/".substr($class, strlen($prefix)).".class.php";
      
      //Include the file
      if (@include_once($classFile)) return TRUE;
    }
    //Class is not part of widgets
    return FALSE;
  }

  /**
   * Magic setter method. Whenever an inaccesible property is set this method is called.
   * The property is then set in our atrbs array instead. This is used at attributes on our HTML elements
   * @param $k The property name
   * @param $v The property value
   * @return null
   */
  public function __set($k, $v){
    $this->atrbs[$k] = $v;
  }

  /**
   * Magic getter method. Whenever an inaccesible property is getted this method is called
   * The property is then found in the atrbs array.
   * If the id is get, and no id has been set before, set a default one
   * @param $k The property name
   */
  public function __get($k) {

  	// Set default id if none has been set the first time it is get
  	if($k == 'id' && (!isset($this->atrbs[$k]) || $this->atrbs[$k] == null)){

      $tmp = explode('_', get_class($this));
  		$shortName = array_pop($tmp);
  		
      $this->id = uniqid($shortName . '_');
  	}
    //Supress errors, so that null is returned when nothing is found in array
    return @$this->atrbs[$k];
  }

  /**
   * Implode all the attributes to a string to put on a HTML element
   * @return string containing the attributes
   */
  protected function GetAttributes(){
    $this->atrbs['class'] = $this->GetClasses();
    ksort($this->atrbs);
    $atrb = '';
    foreach ($this->atrbs as $key => $value) $atrb .= $key . '="' . $value . '" ';
    return trim($atrb);
  }

  /**
   * Get the classes of this element
   * @return string containing the classes to put on a HTML element
   */
  protected function GetClasses() {
    $classesStr = '';
    foreach ($this->classes as $c) $classesStr .= $c.' ';
    return trim($classesStr);
  }

  /**
   * Add a js string to this class. MD5 it to be key, so that we do not add the same js multiple times
   * MD5 is not completely unique, but close enough for our use
   * @param $js The js
   * @param $id The optional id to store is by
   * @return null
   */
  public function AddJs($js, $id = null) {
    if ($id == null) $id = md5($js);
    $this->js[$id] = $js;
  }

  /**
   * Add a css string to this class. MD5 it to be key, so that we do not add the same css multiple times
   * MD5 is not completely unique, but close enough for our use
   * @param $css The css
   * @param $id The optional id to store is by
   * @return null
   */
  public function AddCss($css, $id = null) {
    if ($id == null) $id = md5($css);
    $this->css[$id] = $css;
  }

  /**
   * Add a js file to this class. Use the path as key so that we do not add the same file multiple times
   * @param $path The file
   * @param $id The optional id to store is by
   * @return null
   */
  public function AddJsFile($path, $id = null) {
    if ($id == null) $id = $path;
    $this->jsFiles[$id] = $path;
  }
  
  /**
   * Add a css file to this class. Use the path as key so that we do not add the same file multiple times
   * @param $path The file
   * @param $id The optional id to store is by
   * @return null
   */
  public function AddCssFile($path, $id = null) {
    if ($id == null) $id = $path;
    $this->cssFiles[$id] = $path;
  }

  /**
   * Return the array containing js
   * @return Array containing the js
   */
  public function GetJs() {
    return $this->js;
  } 

  /**
   * Return the array containing css
   * @return Array containing the css
   */
  public function GetCss() {
    return $this->css;
  }

  /**
   * Return the array containing js files
   * @return Array containing the js files
   */
  public function GetJsFiles() {
    return $this->jsFiles;
  }
  
  /**
   * Return the array containing css files
   * @return Array containing the css files
   */
  public function GetCssFiles() {
    return $this->cssFiles;
  }
  
  /**
   * Add an option to the page
   * @param $text The text on the link
   * @param $url The url to link to
   */
  public function AddOption($text, $url) {
  
  	$this->options[$text] = $url;
  }

  /**
   * Get the options defined on page
   * @return Array containing the options
   */
  public function GetOptions() {
  
  	return $this->options;
  }

  /**
   * Set the title of this page
   * @param $title The title to set
   * @return null
   */
  public function SetTitle($title) {
  
  	$this->title = $title;
  }

  /**
   * Get the title of this page
   */
  public function GetTitle() {
  
  	return $this->title;
  }

  /**
   * Widgets must override ToHtml method to provide their markup
   * @return The HTML string
   */
  public abstract function ToHtml();
}
