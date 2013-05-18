<?php
	
/**
 * Class for parsing json. Simple right now, but could be extended
 */
class JsonParser {

	/**
	 * Parse object to json
	 * @param $object The object to parse
	 */
	public static function ToJson($object) {
		return json_encode($object);
	}
	
	/**
	 * Parse json to object
   * @param $stream The json stream to parse
   * @return Object
	 */
	public static function FromJson($stream) {
		return json_decode($stream);
	}
}
