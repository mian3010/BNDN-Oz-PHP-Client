<?php

class Account_Controller_Default extends CommonController {

  /**
   * Constructor. Instantiates the model needed
   */
  public function __construct(){
    $this->accountModel = CommonModel::GetModel("Account");
  }

  /**
   * View a single account
   * @param $username The username of the account to view
   * @return Account_Widget_ViewAccount
   */
  public function View($username){
    try {
      if(!isset($_SESSION['token'])) throw new UnauthorizedException();
      $user = $this->accountModel->GetAccount($username, $_SESSION['token']->token);
      $edit = FALSE;
      if(isset($_SESSION['username']) && strtolower($_SESSION['username']) == strtolower($username))
        $edit = TRUE;
      else if(isset($_SESSION['type']) && strtolower($_SESSION['type']) == 'admin')
        $edit = TRUE;
      return new Account_Widget_ViewAccount($username, $user, $edit);
    } catch (UnauthorizedException $e) {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (ForbiddenException $e) {
      RentItInfo("You do not have permission to view this account");
      RentItGoto(); 
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto();
    }
  }

  /**
   * Create an account
   * @return Account_Widget_CreateAccount
   */
  public function Create(){
    try {
      $admin = FALSE;
      if(isset($_SESSION['token']) && isset($_SESSION['username'])){
        if(isset($_SESSION['type']) && strtolower($_SESSION['type']) == 'admin') $admin = TRUE;
      }
      return new Account_Widget_CreateAccount($admin);
    } catch (UnauthorizedException $e) {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto();
    }
  }

  /**
   * View all accounts
   * @param $types The types to include. String containing values A/P/C
   * @param $incBanned Whether or not to include banned accounts
   * @return 
   */
  public function ViewAll($types = 'PC', $incBanned = FALSE){ //TODO
    try {
      if (!isset($_SESSION['token']) || !isset($_SESSION['username'])) throw new UnauthorizedException();
      if(isset($_SESSION['type']) && strtolower($_SESSION['type']) == 'admin'){
        $types = str_ireplace('a', '', $types);
        $incBanned = FALSE;
      }
      $accounts = $this->accountModel->GetAccounts($types, $incBanned, 'more', $_SESSION['token']->token);
      return new Account_Widget_ViewAccounts($accounts);
    } catch (UnauthorizedException $e) {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto();
    }
  }

  /**
   * Save changes made to an account
   * @return $username The username to update
   * @return null
   */
  public function SaveAccountChanges($username){
    // Build info array
    $info = array();
    foreach ($_POST as $k => $v){
      if(trim($v) != '' && (strtolower(trim($v)) != 'change password'))
        $info[$k] = $v;
    }

    try{
      if(!isset($_SESSION['token'])) throw new UnauthorizedException();
      $this->accountModel->UpdateAccount($username, $info, $_SESSION['token']->token);
    } catch (UnauthorizedException $e){
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto();
    }
    RentItSuccess('Account has been updated');
    RentItGoto('Account', 'View/' . $username);
  }

  /**
   * Save a new account
   * @return null
   */
  public function SaveNewAccount(){
    $error = FALSE;
    if(!isset($_POST['username'])){
      RentItError('Please fillout username');
      $error = TRUE;
    }
    if(!isset($_POST['password'])){
      RentItError('Please fillout password');
      $error = TRUE;
    }
    if($error) RentItGoto("Account", "Create");
    // Build info array
    $info = array();
    //file_put_contents('test.txt', print_r($_POST, TRUE));
    foreach ($_POST as $k => $v){
      if(trim($v) != '' && !strtolower(trim($v)) != 'change password')
      $info[$k] = $v;
    }

    try{
      if(!isset($info['type']) || trim($info['type'])=='')
        $info['type'] = 'Customer';
      $this->accountModel->CreateAccount($info['username'], $info, $_SESSION['token']->token);
    } catch (UnauthorizedException $e){
      RentItError('Permission denied');
      RentItGoto("Account", "Create");
    } catch (Exception $e){
      RentItError('Server error');
      RentItGoto();
    }
    RentItSuccess('Account created');
    RentItGoto('Account', 'View/' . $info['username']);
  }

  /**
   * View a users dashboard. Has two states. One for customers and one for content providers
   * @return Account_Widget_AccountDashboard or Account_Widget_ContentProviderDasboard
   */
  public function Dashboard(){
    if(isset($_SESSION['token']) && isset($_SESSION['username']) && isset($_SESSION['type'])){
      $pum = CommonModel::GetModel("Purchase");
      $prm = CommonModel::GetModel("Product");
      if (strtolower($_SESSION['type']) == 'customer') {
        $purchases = $pum->GetPurchases($_SESSION['username'], $_SESSION['token']->token);
        //Save all- products associated with purchases here
        $products = array();
        //List of ids that has been bought
        $buys = array();
        //Lit of ids that has been rentet
        $rents = array();
        //Go through purchases
        foreach ($purchases as $purchase) {
          //If product has not been loaded before, do it.
          if (!isset($products[$purchase->product])) {
            $products[$purchase->product] = array(
              'product'  => $prm->GetProduct($purchase->product),
              'buy' => null,
              'rent' => null,
            );
          }

          //If this purchase is a buy, put it in buys, and put purchase in buy for the product
          if ($purchase->type == "B") {
            $buys[] = $purchase->product;
            $products[$purchase->product]["buy"] = $purchase;
          }
          //If this purchase is a rent, put it in rents, and put purchase in rent for the product
          else if ($purchase->type == "R") {
            $rents[] = $purchase->product;
            $products[$purchase->product]["rent"] = $purchase;
          }
        }
        return new Account_Widget_AccountDashboard($purchases, $products, $buys, $rents);
      } else if (strtolower($_SESSION['type']) == 'content provider') {
        $products = $prm->GetProductsByContentProvider($_SESSION['username'], $_SESSION['token']->token, null, null, "true");
        $published = array();
        $unpublished = array();
        foreach ($products as $product) {
          //If product is published put it in published array
          if ($product->published == true) $published[] = $product;
          else $unpublished[] = $product;
        }
        return new Account_Widget_ContentProviderDashboard($published, $unpublished);
      } else {
        //User are admin
        return new Widget_Label('Welcome '.$_SESSION['type']);
      }
    } else {
      RentItError('Please authenticate');
      RentItGoto("Auth", "Login");
    }
  }
}
