<?php
/**
 * Base class for all models
 * Containing functionality for throwing exceptions if errors occur from webservice layer
 * With possibility to override which exception is thrown at which status code
 */
abstract class CommonModel {
	protected $httpStatusCodeToException;
	private static $models = array();

  /**
   * Static method for instantiating a model. Singleton pattern,
   * as only one instance of each model can be created
   * @param $module The module the model is in
   * @param $specific The specific model.
   * @return The model object
   */
	public static function GetModel($module, $specific = 'Default') {
		if (!isset(self::$models[$module])) {
			$model = $module.'_Model_'.$specific;
			self::$models[$module][$specific] = new $model();
		}
		return self::$models[$module][$specific];
	}

  /**
   * Constructor. Fill out map deciding exception to throw on each status code
   */
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
	 * @param $key The status code
   * @param $exception The new exception to throw instead
   * @return null
	 */
	protected function OverrideStatusCodeToExceptionMap($key, $exception) {
		$this->httpStatusCodeToException[$key] = $exception;	
	}
	
	/**
	 * Throw an exception if the code should throw one
	 * @param $code The status code to check
	 * @return null
	 */
	protected function ThrowExceptionIfError($code) {
		if(array_key_exists($code, $this->httpStatusCodeToException)) throw $this->httpStatusCodeToException[$code];
	}
}
