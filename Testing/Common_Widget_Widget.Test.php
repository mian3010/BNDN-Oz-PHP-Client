<?php
require_once('Testing_Base.class.php');
class Common_Widget_Widget_Test extends Testing_Base {
  public function testGetClasses() {
    $w = new Widget_Container();
    $w->classes = array('test', 'class');

    $expString = 'test class';
    $method = $this->GetMethod('Widget_Container', 'GetClasses');
    $this->assertEquals($expString, $method->invoke($w));
  }

  /**
   * @depends testGetClasses
   */
  public function testGetAttributes() {
    $w = new Widget_Container();
    $w->id = 'testid';
    $w->atr1 = 'test1';
    $w->atr2 = 'test2';

    $expString = 'atr1="test1" atr2="test2" class="" id="testid"';
    $method = $this->GetMethod('Widget_Container', 'GetAttributes');
    $this->assertEquals($expString, $method->invoke($w));
  }

  public function testAddJs() {

  }

  public function testAddCss() {

  }

  public function testAddJsFiles() {

  }

  public function testAddCssFiles() {

  }

  /**
   * @depends testAddJs
   */
  public function testGetJs($data) {

  }

  /**
   * @depends testAddCss
   */
  public function testGetCss($data) {

  }

  /**
   * @depends testAddJsFiles
   */
  public function testGetJsFiles($data) {

  }

  /**
   * @depends testAddCssFiles
   */
  public function testGetCssFiles($data) {

  }
}
