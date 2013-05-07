<?php

/**
 * 
 * 
 *
 */
class Product implements JsonSerializable {
	
	public $title;
	public $description;
	public $type;
	public $price;
	public $rating;
	public $owner;
	public $meta;
	public $published;
	
	/**
	 * Sets the title of the product.
	 * @param string $title
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * Sets the description of the product.
	 * @param string $desciption
	 */
	public function SetDescription($desciption) {
		$this->description = $description;
	}
	
	/**
	 * Sets the buy and/or rent prices of the product.
	 * @param array $price
	 */
	public function SetPrice($price) {
		$this->price = $price;
	}
	
	/**
	 * Sets the score and count of the product's rating. 
	 * @param array $rating
	 */
	public function SetRating($rating) {
		$this->rating = $rating;
	}
	
	/**
	 * Sets the name of the owner of the product.
	 * @param string $owner
	 */
	public function SetOwner($owner) {
		$this->owner = $owner;
	}
	
	/**
	 * Sets the meta data of the product.
	 * @param array $meta
	 */
	public function SetMeta($meta) {
		$this->meta = $meta;
	}
	
	/**
	 * Set whether the product is published or not.
	 * @param bool $published
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