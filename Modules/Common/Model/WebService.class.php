<?php
/**
 * Class for calling our webservices
 */
class WebService {
  private static $webServiceUri = 'http://rentit.itu.dk/RentIt27/RentItService.svc/';
  private $request;

  /**
   * Constructor. Sets the service (URI) and the method(GET/POST/PUT/DELETE)
   * @param $service The service to call
   * @param $method The method to use
   */
  public function __construct($service, $method) {
    $this->service = $service;
    $this->method = $method;
  }

  /**
   * Set the data used in this call
   * @param $data The data to set. Can be object to send, or array on data if method is GET
   * @return null
   */
  public function SetData($data) {
    $this->data = $data;
  }

  /**
   * Set the token used in this service call
   * @param $token The token string
   * @return null
   */
  public function SetToken($token) {
    $this->token = $token;
  }

  /**
   * Execute the service call
   * @return The deserialized object returned from service call
   */
  public function Execute() {
    $requestUri = self::$webServiceUri.$this->service;
    //If this is get add data to URI
    if ($this->method == "GET") $requestUri .= '?'.$this->joinGetData();

    //Set content type
    $header = array(
      'Content-type: application/json',
    );
    //Set token if applicable
    if (isset($this->token)) $header[] = 'token: '.$this->token;

    //Init the request
    $curl = curl_init($requestUri);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($this->method));
    if (isset($this->data))
      curl_setopt($curl, CURLOPT_POSTFIELDS, JsonParser::ToJson($this->data));

    //Execute the request
    $json = curl_exec($curl);
    //Set status code on us
    $this->httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($this->httpStatusCode >= 500 && $this->httpStatusCode <= 599) {
      RentItError("Server error");
      RentItGoto("Error", "Fatal");
    }

    return JsonParser::FromJson($json);
  }

  /**
   * Get the status code from us. 
   * @return The status code
   */
  public function GetHttpStatusCode() {
    if (isset($this->httpStatusCode)) return $this->httpStatusCode;
    else return 0;
  }

  /**
   * Join the data for a get request
   * @return string for appending to get uri
   */
  private function joinGetData() {
    if (!isset($this->data)) return '';
    $datas = array();
    foreach ($this->data as $k => $v) {
      $datas[] = $k.'='.$v;
    }
    return implode("&", $datas);
  }

  /**
   * Return the absolute service uri from a relative one. Used for thumbnails
   * @param $relative The relative path
   * @return The absolute path
   */
  public static function GetAbsolute($relative) {
    return self::$webServiceUri.ltrim($relative, "/");
  }
}
