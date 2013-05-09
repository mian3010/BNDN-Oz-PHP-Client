<?php

abstract class CommonModel {
	protected $httpStatusCodeToException;
	private static $models = array();
	
	public static function GetModel($module, $specific = 'Default') {
		if (!isset(self::$models[$module])) {
			$model = $module.'_Model_'.$specific;
			self::$models[$module][$specific] = new $model();
		}
		return self::$models[$module][$specific];
	}
	
	private function __construct() {
		$httpStatusCodeToException[400] = new BadRequestException();
		$httpStatusCodeToException[401] = new UnauthorizedException();
		$httpStatusCodeToException[402] = new PaymentRequiredException();
		$httpStatusCodeToException[403] = new ForbiddenException();
		$httpStatusCodeToException[404] = new NotFoundException();
		$httpStatusCodeToException[405] = new MethodNotAllowedException();
		$httpStatusCodeToException[406] = new NotAcceptableException();
		$httpStatusCodeToException[407] = new ProxyAuthenticationRequiredException();
		$httpStatusCodeToException[408] = new RequestTimeoutException();
		$httpStatusCodeToException[409] = new ConflictException();
		$httpStatusCodeToException[410] = new GoneException();
		$httpStatusCodeToException[411] = new LengthRequiredException();
		$httpStatusCodeToException[412] = new PreconditionFailedException();
		$httpStatusCodeToException[413] = new RequestEntityTooLargeException();
		$httpStatusCodeToException[414] = new RequestUriTooLongException();
		$httpStatusCodeToException[415] = new UnsupportedMediaTypeException();
		$httpStatusCodeToException[416] = new RequestedRangeNotSatisfiableException();
		$httpStatusCodeToException[417] = new ExpectationFailedException();
		$httpStatusCodeToException[500] = new ServerErrorException();
		$httpStatusCodeToException[501] = new NotImplementedException();
		$httpStatusCodeToException[502] = new BadGateWayException();
		$httpStatusCodeToException[503] = new ServiceUnavailableException();
		$httpStatusCodeToException[504] = new GatewayTimeoutException();
		$httpStatusCodeToException[505] = new HttpVersionNotSupportedException();
	}
	
	/**
	 * Sets a status code to an exception in the httpStatusCodeToExceptionMap.
	 * @param int $key
	 * @param exception $value
	 */
	protected function OverrideStatusCodeToExceptionMap($key, $exception) {
		$httpStatusCodeToException[$key] = $exception;	
	}
	
	/**
	 * 
	 * @param int $code
	 * @throws Exception if error code recieved from server.
	 */
	protected function ThrowExceptionIfError($code) {
		if(array_key_exists($code, $httpStatusCodeToException)) throw $httpStatusCodeToException[$code];
	}
}
