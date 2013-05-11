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

  public function testAddGetJs() {
    $w = new Widget_Container();
    $method = $this->GetMethod('Widget_Container', 'AddJs');

    $test = array(
      'testjs1',
      'testjs2',
      'testing',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w, array($test[1]));
    $method->invokeArgs($w, array($test[2], $test[2]));

    $js = $w->GetJs();

    $this->assertArrayHasKey(md5($test[0]), $js);
    $this->assertEquals($test[0], $js[md5($test[0])]);
    $this->assertArrayHasKey(md5($test[1]), $js);
    $this->assertEquals($test[1], $js[md5($test[1])]);
    $this->assertArrayHasKey($test[2], $js);
    $this->assertEquals($test[2], $js[$test[2]]);
  }

  public function testAddGetJsWithChildren() {
    $w = new Widget_Container();
    $w2 = new Widget_Container();
    $w->widgets[] = $w2;

    $method = $this->GetMethod('Widget_Container', 'AddJs');

    $test = array(
      'testjs1',
      'testjs2',
      'testing',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w2, array($test[1]));
    $method->invokeArgs($w2, array($test[2], $test[2]));

    $js = $w->GetJs();

    $this->assertArrayHasKey(md5($test[0]), $js);
    $this->assertEquals($test[0], $js[md5($test[0])]);
    $this->assertArrayHasKey(md5($test[1]), $js);
    $this->assertEquals($test[1], $js[md5($test[1])]);
    $this->assertArrayHasKey($test[2], $js);
    $this->assertEquals($test[2], $js[$test[2]]);
  }

  public function testAddGetCss() {
    $w = new Widget_Container();
    $method = $this->GetMethod('Widget_Container', 'AddCss');

    $test = array(
      'testcss1',
      'testcss2',
      'testingcss',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w, array($test[1]));
    $method->invokeArgs($w, array($test[2], $test[2]));

    $css = $w->GetCss();

    $this->assertArrayHasKey(md5($test[0]), $css);
    $this->assertEquals($test[0], $css[md5($test[0])]);
    $this->assertArrayHasKey(md5($test[1]), $css);
    $this->assertEquals($test[1], $css[md5($test[1])]);
    $this->assertArrayHasKey($test[2], $css);
    $this->assertEquals($test[2], $css[$test[2]]);
  }

  public function testAddGetCssWithChildren() {
    $w = new Widget_Container();
    $w2 = new Widget_Container();
    $w->widgets[] = $w2;

    $method = $this->GetMethod('Widget_Container', 'AddCss');

    $test = array(
      'testcss1',
      'testcss2',
      'testingcss',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w2, array($test[1]));
    $method->invokeArgs($w2, array($test[2], $test[2]));

    $css = $w->GetCss();

    $this->assertArrayHasKey(md5($test[0]), $css);
    $this->assertEquals($test[0], $css[md5($test[0])]);
    $this->assertArrayHasKey(md5($test[1]), $css);
    $this->assertEquals($test[1], $css[md5($test[1])]);
    $this->assertArrayHasKey($test[2], $css);
    $this->assertEquals($test[2], $css[$test[2]]);
  }

  public function testAddGetJsFiles() {
    $w = new Widget_Container();
    $method = $this->GetMethod('Widget_Container', 'AddJsFile');

    $test = array(
      'testjs1',
      'testjs2',
      'testing',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w, array($test[1]));
    $method->invokeArgs($w, array($test[2], $test[2]."lol"));

    $js = $w->GetJsFiles();

    $this->assertArrayHasKey($test[0], $js);
    $this->assertEquals($test[0], $js[$test[0]]);
    $this->assertArrayHasKey($test[1], $js);
    $this->assertEquals($test[1], $js[$test[1]]);
    $this->assertArrayHasKey($test[2]."lol", $js);
    $this->assertEquals($test[2], $js[$test[2]."lol"]);
  }

  public function testAddGetJsFilesWithChildren() {
    $w = new Widget_Container();
    $w2 = new Widget_Container();
    $w->widgets[] = $w2;

    $method = $this->GetMethod('Widget_Container', 'AddJsFile');

    $test = array(
      'testjs1',
      'testjs2',
      'testing',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w2, array($test[1]));
    $method->invokeArgs($w2, array($test[2], $test[2]."lol"));

    $js = $w->GetJsFiles();

    $this->assertArrayHasKey($test[0], $js);
    $this->assertEquals($test[0], $js[$test[0]]);
    $this->assertArrayHasKey($test[1], $js);
    $this->assertEquals($test[1], $js[$test[1]]);
    $this->assertArrayHasKey($test[2]."lol", $js);
    $this->assertEquals($test[2], $js[$test[2]."lol"]);
  }

  public function testAddGetCssFiles() {
    $w = new Widget_Container();
    $method = $this->GetMethod('Widget_Container', 'AddCssFile');

    $test = array(
      'testcss1',
      'testcss2',
      'testingcss',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w, array($test[1]));
    $method->invokeArgs($w, array($test[2], $test[2]."lol"));

    $css = $w->GetCssFiles();

    $this->assertArrayHasKey($test[0], $css);
    $this->assertEquals($test[0], $css[$test[0]]);
    $this->assertArrayHasKey($test[1], $css);
    $this->assertEquals($test[1], $css[$test[1]]);
    $this->assertArrayHasKey($test[2]."lol", $css);
    $this->assertEquals($test[2], $css[$test[2]."lol"]);
  }

  public function testAddGetCssFilesWithChildren() {
    $w = new Widget_Container();
    $w2 = new Widget_Container();
    $w->widgets[] = $w2;

    $method = $this->GetMethod('Widget_Container', 'AddCssFile');

    $test = array(
      'testcss1',
      'testcss2',
      'testingcss',
    );

    $method->invokeArgs($w, array($test[0]));
    $method->invokeArgs($w2, array($test[1]));
    $method->invokeArgs($w2, array($test[2], $test[2]."lol"));

    $css = $w->GetCssFiles();

    $this->assertArrayHasKey($test[0], $css);
    $this->assertEquals($test[0], $css[$test[0]]);
    $this->assertArrayHasKey($test[1], $css);
    $this->assertEquals($test[1], $css[$test[1]]);
    $this->assertArrayHasKey($test[2]."lol", $css);
    $this->assertEquals($test[2], $css[$test[2]."lol"]);
  }
}
