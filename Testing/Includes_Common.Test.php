<?php
require_once('Testing_Base.class.php');
class Includes_Common_Test extends Testing_Base {
  
  public function testRentItError(){
  
  	// Initiate
  	unset($_SESSION['errors']);
  	
  	// Test values
  	$testValues = array('error1', 'error2');
  	
  	RentItError($testValues[0]);
  	RentItError($testValues[1]);
  	
  	$this->assertEquals($_SESSION['errors'], $testValues);
  }
  
  public function testRentItInfo(){
  
  	// Initiate
  	unset($_SESSION['info']);
  	
  	// Test values
  	$testValues = array('info1', 'info2');
  	
  	RentItInfo($testValues[0]);
  	RentItInfo($testValues[1]);
  	
  	$this->assertEquals($_SESSION['info'], $testValues);
  }
 
  public function testRentItSuccess(){
  
  	// Initiate
  	unset($_SESSION['successes']);
  	
  	// Test values
  	$testValues = array('success1', 'success2');
  	
  	RentItSuccess($testValues[0]);
  	RentItSuccess($testValues[1]);
  	
  	$this->assertEquals($_SESSION['successes'], $testValues);
  }
  
  public function testMessageClearance(){
  
  	RentItError('message1');
  	RentItError('message2');
  	RentItInfo('message3');
  	RentItInfo('message4');
  	RentItSuccess('message5');
  	RentItSuccess('message6');
  	
  	$notifications = new Widget_Notifications();
  	$notifications.ToHtml(); // Clears the messages?
  	
  	$this->assertEmpty($_SESSION['errors'], 'Error messages not removed!');
  	$this->assertEmpty($_SESSION['info'], 'Info messages not removed!');
  	$this->assertEmpty($_SESSION['successes'], 'Success messages not removed!');
  }
}
