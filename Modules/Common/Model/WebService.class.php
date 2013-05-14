<?php

class WebService {
  private static $webServiceUri = 'http://rentit.itu.dk/RentIt27/RentItService.svc/';
  private $request;

  public function __construct($service, $method) {
    $this->service = $service;
    $this->method = $method;
  }

  public function SetData($data) {
    $this->data = $data;
  }

  public function SetToken($token) {
    $this->token = $token;
  }

  public function Execute() {
    $requestUri = self::$webServiceUri.$this->service;
    if ($this->method == "GET") $requestUri .= '?'.$this->joinGetData();

    $header = array(
      'Content-type: application/json',
    );
    if (isset($this->token)) $header[] = 'token: '.$this->token;

    $curl = curl_init($requestUri);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($this->method));
    if (isset($this->data))
      curl_setopt($curl, CURLOPT_POSTFIELDS, JsonParser::ToJson($this->data));

    $json = curl_exec($curl);
    $this->httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    return JsonParser::FromJson($json);
  }

  public function GetHttpStatusCode() {
    if (isset($this->httpStatusCode)) return $this->httpStatusCode;
    else return 0;
  }

  private function joinGetData() {
    if (!isset($this->data)) return '';
    $datas = array();
    foreach ($this->data as $k => $v) {
      $datas[] = $k.'='.$v;
    }
    return implode("&", $datas);
  }

  public static function GetAbsolute($relative) {
    return self::$webServiceUri.ltrim($relative, "/");
  }
}
