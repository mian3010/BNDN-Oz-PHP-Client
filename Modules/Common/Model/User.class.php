<?php

/**
 * 
 * @author
 *
 */
class User implements JsonSerializable {
	
	public $user;
	public $email;
	public $password;
	public $type;
	public $banned;
	public $name;
	public $address;
	public $postal;
	public $country;
	public $birth;
	public $about;
	public $credits;
	public $credits;
	public $authenticated;
	public $purchaseHistory;
	
	/**
	 * 
	 * @param unknown $user
	 */
	public function SetUser($user) {
		$this->user = $user;
	}
	
	/**
	 * 
	 * @param unknown $email
	 */
	public function SetEmail($email) {
		$this->email = $email;
	}
	
	/**
	 * 
	 * @param unknown $password
	 */
	public function SetPassword($password) {
		$this->password = $password;
	}
	
	/**
	 * 
	 * @param unknown $type
	 */
	public function SetType($type) {
		$this->type = $type;
	}
	
	/**
	 * 
	 * @param unknown $banned
	 */
	public function SetBanned($banned) {
		$this->banned = $banned;
	}
	
	/**
	 * 
	 * @param unknown $name
	 */
	public function SetName($name) {
		$this->name = $name;
	}
	
	/**
	 * 
	 * @param unknown $address
	 */
	public function SetAddress($address) {
		$this->address = $address;
	}
	
	/**
	 * 
	 * @param unknown $postal
	 */
	public function SetPostal($postal) {
		$this->postal = $postal;
	}
	
	/**
	 * 
	 * @param unknown $country
	 */
	public function SetCountry($country) {
		$this->country = $country;
	}
	
	/**
	 * 
	 * @param unknown $birth
	 */
	public function SetBirth($birth) {
		$this->birth = $birth;
	}
	
	/**
	 * 
	 * @param unknown $about
	 */
	public function SetAbout($about) {
		$this->about = $about;
	}
	
	/**
	 * 
	 * @param unknown $credits
	 */
	public function SetCredits($credits) {
		$this->credits = $credits;
	}
	
	/**
	 * 
	 * @return multitype:unknown
	 */
	function jsonSerialize() {
		$data = array();
		foreach($this as $key => $value) {
			if($value!=null) {
				$data[$key] = $value;
			}
		}
		return $data;
	}
}