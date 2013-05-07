<?php

class Product implements JsonSerializable {
	
	public $title;
	public $description;
	public $type;
	public $price = array();
	public $rating = array();
	public $owner;
	public $meta = array();
	public $published;
	
	/**
	 * 
	 * @param unknown $title
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * 
	 * @param unknown $desciption
	 */
	public function SetDescription($desciption) {
		$this->description = $description;
	}
	
	/**
	 * 
	 * @param unknown $price
	 */
	public function SetPrice($price) {
		$this->price = $price;
	}
	
	/**
	 * 
	 * @param unknown $rating
	 */
	public function SetRating($rating) {
		$this->rating = $rating;
	}
	
	/**
	 * 
	 * @param unknown $owner
	 */
	public function SetOwner($owner) {
		$this->owner = $owner;
	}
	
	/**
	 * 
	 * @param unknown $meta
	 */
	public function SetMeta($meta) {
		$this->meta = $meta;
	}
	
	/**
	 * 
	 * @param unknown $published
	 */
	public function SetPublished($published) {
		$this->published = $published;
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