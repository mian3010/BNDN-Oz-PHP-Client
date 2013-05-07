<?php
	
class JsonParser {

	/**
	 * 
	 * @param $data
	 */
	public static function ToJson($object) {
		return json_encode($object);
	}
	
	/**
	 * 
	 * @param $stream
	 */
	public static function FromJson($stream) {
		return json_decode($stream);
	}
}
