<?php
/** 
 * User: Tuna
 * Date: 17.09.2015
 * Time: 22:04
 * Company: Uretgec
 * URI: www.uretgec.com
 */

namespace Oauth2r\Instagram\Library;

/*
 * Debug Mode
 * Get Authorize
 * Get Access Token
 * Get - Post - Del - Subscribe Pattern
 * */
use Oauth2r\Instagram\Config\ParameterConfig;
use Oauth2r\Instagram\Config\PatternConfig;
use Oauth2r\Instagram\Enum\MethodType;

class InstagramClient
{
	const API_URL = 'https://api.instagram.com/';
	private $client_id;
	private $client_secret;
	private $callback_url;
	private $access_token = null;
	private $code = null;

	protected $parameters = array();
	protected $data = null;
	protected $data_response = null;
	protected $debug = false;
	protected $dump;
	protected $url = null;
	protected $pattern = null;

	public function __construct ($client_id, $client_secret, $callback_url, $debug = false)
	{
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->callback_url = $callback_url;

		$this->debug = $debug;
		$this->dump = [];
	}

	/*
	 * Get -Set Functions
	 * */
	public function setClientId($client_id)
	{
		$this->client_id = $client_id;
		return $this;
	}

	public function getClientId()
	{
		return $this->client_id;
	}

	public function setClientSecret($client_secret)
	{
		$this->client_secret = $client_secret;
		return $this;
	}

	public function getClientSecret()
	{
		return $this->client_secret;
	}

	public function setCallbackUrl($callback_url)
	{
		$this->callback_url = $callback_url;
		return $this;
	}

	public function getCallbackUrl()
	{
		return $this->callback_url;
	}

	public function setAccessToken($access_token)
	{
		$this->access_token = $access_token;
		return $this;
	}

	public function getAccessToken()
	{
		return $this->access_token;
	}

	public function setParameters($parameters)
	{
		$this->parameters = $parameters;
		return $this;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setDataResponse($data_response)
	{
		$this->data_response = $data_response;
		return $this;
	}

	public function getDataResponse()
	{
		return $this->data_response;
	}

	public function setDebug($debug)
	{
		$this->debug = $debug;
		return $this;
	}

	public function getDebug()
	{
		return $this->debug;
	}

	public function setDump($dump)
	{
		$this->dump[] = $dump;
		return $this;
	}

	public function getDump()
	{
		return $this->dump;
	}

	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setCode($code)
	{
		$this->code = $code;

		return $this;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setPattern($pattern)
	{
		$this->pattern = $pattern;

		return $this;
	}

	public function getPattern()
	{
		return $this->pattern;
	}

	/*
	 * Supported Function
	 * */
	protected function generateRequestUrl()
	{
		$patternUri = PatternConfig::getUrl($this->getPattern());
		$patternUriRegex = '/{\w*}/';

		$requiredParameters = array_flip(PatternConfig::getRequiredParameters($this->getPattern()));
		$optionalParameters = array_flip(PatternConfig::getParameters($this->getPattern()));

		$requiredParameters = array_map(function ($param) {
			return null;
		}, $requiredParameters);

		$optionalParameters = array_map(function ($param) {
			return null;
		}, $optionalParameters);

		$params = array_merge($requiredParameters,$optionalParameters);
		if(is_array($this->getParameters()))
			$params = array_merge($params,$this->getParameters());

		if(array_key_exists(ParameterConfig::CLIENT_ID,$requiredParameters))
			$params['client_id'] = $this->getClientId();
		if(array_key_exists(ParameterConfig::CLIENT_SECRET,$requiredParameters))
			$params['client_secret'] = $this->getClientSecret();
		if(array_key_exists(ParameterConfig::REDIRECT_URL,$requiredParameters))
			$params['redirect_uri'] = $this->getCallbackUrl();
		if(array_key_exists(ParameterConfig::ACCESS_TOKEN,$requiredParameters))
			$params['access_token'] = $this->getAccessToken();
		if(array_key_exists(ParameterConfig::GRANT_TYPE,$requiredParameters))
			$params['grant_type'] = 'authorization_code';

		$setParams = array_filter($params, function ($param) {
			return !is_null($param);
		});

		preg_match_all($patternUriRegex, $patternUri, $matches);
		if(isset($matches[0]) and count($matches[0]) > 0){
			foreach ($matches[0] as $matchItem) {
				$clearMatchItem = str_replace(["{","}"],"",$matchItem);
				if(array_key_exists($clearMatchItem,$setParams)){
					$patternUri = str_replace($matchItem,$setParams[$clearMatchItem],$patternUri);
					unset($setParams[$clearMatchItem]);
				}
			}
		}

		$this->setParameters($setParams);
		// Request: https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=code
		// Success: http://your-redirect-uri?code=CODE
		// Error: http://your-redirect-uri?error=access_denied&error_reason=user_denied&error_description=The+user+denied+your+request

		$url = sprintf(self::API_URL.$patternUri."?%s",http_build_query($this->getParameters(), null, '&'));
		$this->setUrl($url);
	}

	protected function generateResponse($method)
	{
		$this->generateRequestUrl();

		var_dump($this->getUrl());
		exit;
		$response = $this->callCurl($method,$this->getUrl(), $this->getParameters());
		$this->setDataResponse($response);

		if($this->getDebug()) {
			$this->setDump([
				'response' => $this->getDataResponse()
				, 'url' => $this->getUrl()
				, 'params' => $this->getParameters(),
			]);
		}
	}

	public function doRequest($method, $pattern = null, $params = array())
	{
		if(!array_key_exists($pattern, PatternConfig::getUrl()))
			throw new \Exception("Pattern not found.");

		$this->setPattern($pattern);
		$this->setParameters($params);

		$this->generateResponse($method);
		return $this->getData();
	}

	/*Check Response*/
	public function isSuccess()
	{
		$response = $this->getData();
		if(isset($response['result']) and $response['result'] === ResultType::SUCCESS)
			return true;

		return false;
	}

	public function errors()
	{
		// Error: http://your-redirect-uri?error=access_denied&error_reason=user_denied&error_description=The+user+denied+your+request
		$response = $this->getData();
		if(isset($response['result']) and $response['result'] === ResultType::ERROR)
			return $response['message'] || null;

		return null;
	}

	/*
	 * Curl
	 * */
	public static function callCurl($method,$url, $params)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSLVERSION, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type" => "application/x-www-form-urlencoded"));
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);

		curl_close($ch);

		if(!$result)
			throw new \Exception(
				sprintf(
					'%s url not response.',
					$url
				));

		return $result;
	}


	/*
	 * Authorization
	 * */
	public function clientAuthorize()
	{

	}
	public function authorize()
	{

	}

	/*
	 * Use Only Get Pattern
	 * */
	public function get($pattern = null,$params = null)
	{
		$response = $this->doRequest(MethodType::GET,$pattern,$params);
		return $response;
	}

	/*
	 * Use Only Post Pattern
	 * */
	public function post($pattern = null,$params = null)
	{
		$response = $this->doRequest(MethodType::POST,$pattern,$params);
		return $response;
	}

	/*
	 * Use Only Del Pattern
	 * */
	public function del($pattern = null,$params = null)
	{
		$response = $this->doRequest(MethodType::DEL,$pattern,$params);
		return $response;
	}

	/*
	 * Use Only Subscribe Pattern
	 * */
	public function subscribe($pattern = null,$params = null)
	{
		$response = $this->doRequest(MethodType::GET,$pattern,$params);
		return $response;
	}

}