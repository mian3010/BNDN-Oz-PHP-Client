<?php

class Credits_Controller_Default extends CommonController {
	
	public function __construct() {
    	$this->creditsModel = CommonModel::GetModel("Credits");
  	}
  /*
   * Add credits to an account
   * @param $amount Amount of credits to be added
   */
  public function UpdateCredits() {
  	if(isset($_SESSION['token'])){
      // Check for empty
      if (!isset($_POST['credits']) || empty($_POST['credits']))  {
        RentItError('Please insert number');
      } else {
          $credits = $_POST['credits'];
          // Check for negative - negative = no good
          if($credits >= 0) {
            // Add the credits!
            try {
              $r = $this->creditsModel->UpdateCredits($_SESSION['token']->token, $credits);
              // Check for errors
              if(r == FALSE) {
                RentItError('Some error occured');
              }
            } catch (Exception $e) {
              RentItError("Error :/ --> $e");
              RentItError('Server error. Please try again later.');
            }
          } else {
            RentItError('Please insert a positive number');
          }
        }
      }
    RentItGoto("Credits", "GetCredits");
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
      $a = $am->GetAccount($_SESSION['username'], $_SESSION['token']->token);
		  $c = $a->credits;
		  return new Credits_Widget_ViewCredits($c);
	}
  }
}
