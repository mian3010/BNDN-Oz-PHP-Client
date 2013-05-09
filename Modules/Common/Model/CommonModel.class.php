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
		$this->httpStatusCodeToException = array(
			400 => new BadRequestException(),
			401 => new UnauthorizedException(),
			402 => new PaymentRequiredException(),
			403 => new ForbiddenException(),
			404 => new NotFoundException(),
			405 => new MethodNotAllowedException(),
			406 => new NotAcceptableException(),
			407 => new ProxyAuthenticationRequiredException(),
			408 => new RequestTimeoutException(),
			409 => new ConflictException(),
			410 => new GoneException(),
			411 => new LengthRequiredException(),
			412 => new PreconditionFailedException(),
			413 => new RequestEntityTooLargeException(),
			414 => new RequestUriTooLongException(),
			415 => new UnsupportedMediaTypeException(),
			416 => new RequestedRangeNotSatisfiableException(),
			417 => new ExpectationFailedException(),
			500 => new ServerErrorException(),
			501 => new NotImplementedException(),
			502 => new BadGateWayException(),
			503 => new ServiceUnavailableException(),
			504 => new GatewayTimeoutException(),
			505 => new HttpVersionNotSupportedException());
	}
	
	/**
	 * Sets a status code to an exception in the httpStatusCodeToExceptionMap.
	 * @param int $key
	 * @param exception $value
	 */
	protected function OverrideStatusCodeToExceptionMap($key, $exception) {
		$this->httpStatusCodeToException[$key] = $exception;	
	}
	
	/**
	 * 
	 * @param int $code
	 * @throws Exception if error code recieved from server.
	 */
	protected function ThrowExceptionIfError($code) {
		if(array_key_exists($code, $this->httpStatusCodeToException)) throw $this->httpStatusCodeToException[$code];
	}
}
