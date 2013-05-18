<?php

class Credits_Controller_Default extends CommonController {
  /**
   * Constructor. Instantiates the model to use
   */	
	public function __construct() {
    	$this->creditsModel = CommonModel::GetModel("Credits");
  	}
  /*
   * Add credits to an account
   * @param $amount Amount of credits to be added
   * @return null
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
              RentItError('Server error. Please try again later.');
            }
          } else {
            RentItError('Please insert a positive number');
          }
        }
      }
    RentItGoto("Credits", "GetCredits");
  }
  /**
   * Show the buy credits widget
   * @return Credits_Widget_BuyCredits
   */ 
  public function buyCredits() {
  	if(isset($_SESSION['token'])){
    		return new Credits_Widget_BuyCredits();
		}
  }

  /*
   * Get credit for an account
   * @return Credits_Widget_ViewCredits
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
