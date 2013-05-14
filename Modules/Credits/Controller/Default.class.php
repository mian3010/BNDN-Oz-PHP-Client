<?php

class Credits_Controller_Default extends CommonController {
	
	public function __construct() {
    	$this->creditsModel = CommonModel::GetModel("Credits");
  	}
  /*
   * Add credits to an account
   * @param $amount Amount of credits to be added
   */
  public function UpdateCredits($amount) {
    	if(isset($_SESSION['token'])){
    		//$r = $this->creditsModel->UpdateCredits($_SESSION['token']->token, $amount);
		}
  }
  
  public function buyCredits() {
  	if(isset($_SESSION['token'])){
    		return new Credits_Widget_BuyCredits();
    	
		}
  }

  /*
   * Get credit for an account
   * @return Credit ammount
   */
  public function GetCredits() {
  	if(isset($_SESSION['token'])){
		$am = CommonModel::GetModel("Account");
		$c = $am->GetAccount($_SESSION['username'], $_SESSION['token']->token)->credits;
		return new Credits_Widget_ViewCredits($c);
	}
  }
}
