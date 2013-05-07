<?php

/**
 * 
 * 
 *
 */
class PurchaseHistory implements JsonSerializable {
	
	public $purchased;
	public $paid;
	public $type;
	public $expires;
	public $product;

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