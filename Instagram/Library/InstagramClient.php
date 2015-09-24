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
	protected $method = null;
	protected $header = null;

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
		$this->data_response = json_decode($data_response);
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

	public function setMethod($method)
	{
		$this->method = $method;

		return $this;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function setHeader($header)
	{
		/*Thanks this function: http://stackoverflow.com/a/18682872*/
		$headers = null;
		if($header !== null) {
			// Split the string on every "double" new line.
			$arrRequests = explode("\r\n\r\n", $header);

			// Loop of response headers. The "count() -1" is to
			//avoid an empty row for the extra line break before the body of the response.
			for ($index = 0; $index < count($arrRequests) -1; $index++) {

				foreach (explode("\r\n", $arrRequests[$index]) as $i => $line)
				{
					if ($i === 0)
						$headers[$index]['http_code'] = $line;
					else
					{
						list ($key, $value) = explode(': ', $line);
						$headers[$index][$key] = $value;
					}
				}
			}
		}

		$this->header = $headers;

		return $this;
	}

	public function getHeader()
	{
		return $this->header;
	}

	/*
	 * Supported Function
	 * */
	protected function httpBuildParameters($params)
	{
		return http_build_query($params, null, '&');
	}
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
			$params[ParameterConfig::CLIENT_ID] = $this->getClientId();
		if(array_key_exists(ParameterConfig::CLIENT_SECRET,$requiredParameters))
			$params[ParameterConfig::CLIENT_SECRET] = $this->getClientSecret();
		if(array_key_exists(ParameterConfig::REDIRECT_URL,$requiredParameters))
			$params[ParameterConfig::REDIRECT_URL] = $this->getCallbackUrl();
		if(array_key_exists(ParameterConfig::ACCESS_TOKEN,$requiredParameters))
			$params[ParameterConfig::ACCESS_TOKEN] = $this->getAccessToken();
		if(array_key_exists(ParameterConfig::GRANT_TYPE,$requiredParameters))
			$params[ParameterConfig::GRANT_TYPE] = 'authorization_code';
		if(array_key_exists(ParameterConfig::RESPONSE_TYPE,$requiredParameters))
			$params[ParameterConfig::RESPONSE_TYPE] = 'code';
		if(array_key_exists(ParameterConfig::SCOPE,$requiredParameters))
			if(isset($params[ParameterConfig::SCOPE]) and is_array($params[ParameterConfig::SCOPE]))
					$params[ParameterConfig::SCOPE] = implode("+",$params[ParameterConfig::SCOPE]);

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

		$url = sprintf(self::API_URL.$patternUri."?%s",$this->httpBuildParameters($this->getParameters()));
		if($this->getMethod() == MethodType::POST)
			$url = sprintf(self::API_URL.$patternUri);

		$this->setUrl($url);
	}

	protected function generateResponse()
	{
		$this->generateRequestUrl();
		if($this->getPattern() == PatternConfig::AUTHORIZE) {
			header('Location: '.$this->getUrl());
			exit;
		}

		$response = $this->callCurl($this->getMethod(),$this->getUrl(), $this->getParameters());
		$this->setHeader($response['header']);
		$this->setDataResponse($response['body']);

		if($this->getDebug()) {
			$this->setDump([
				'response' => $response
				, 'url' => $this->getUrl()
				, 'params' => $this->getParameters(),
			]);
		}
	}

	public function doRequest($method, $pattern = null, $params = array())
	{
		if(!array_key_exists($pattern, PatternConfig::getUrl()))
			throw new \Exception("Pattern not found.");

		$this->setMethod($method);
		$this->setPattern($pattern);
		$this->setParameters($params);

		$this->generateResponse();
		return $this->getDataResponse();
	}

	/*Check Response*/
	public function isAuthSuccess()
	{
		$response = $this->getDataResponse();
		if(isset($response->access_token) and $response->access_token !== null)
			return true;

		return false;
	}

	public function isSuccess()
	{
		$response = $this->getDataResponse();
		if(isset($response->meta) and isset($response->meta->code) and $response->meta->code == 200) {
			if(isset($response->data) and count($response->data) > 0)
				$this->setData($response->data);

			return true;
		}

		return false;
	}

	public function errors()
	{
		$response = $this->getDataResponse();
		if(isset($response->code) and $response->code > 0)
			return $response->error_type. ":" .$response->error_message;

		return null;
	}

	public function isLimitExceeded()
	{
		if( ($header = $this->getHeader()) === null )
			return false;

		$header = current($header);
		$maxLimit = isset($header["X-Ratelimit-Limit"]) ? $header["X-Ratelimit-Limit"] - 5 : 0; // 5000 : Always reserved last 5 request
		$remainingLimit = isset($header["X-Ratelimit-Remaining"]) ? $header["X-Ratelimit-Remaining"] : 0;
		$spentLimit = $maxLimit - $remainingLimit;

		if($spentLimit >= $maxLimit)
			return true;

		return false;
	}

	/*
	 * Curl
	 * */
	public static function callCurl($method,$url,$params)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSLVERSION, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		switch($method)
		{
			case MethodType::GET:
//				curl_setopt($ch, CURLOPT_HEADER, 0);
				break;
			case MethodType::POST:
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, self::httpBuildParameters($params));
//				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type" => "application/x-www-form-urlencoded"));
				break;
			case MethodType::DEL:
				break;
		}
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		/*GET Header With Body*/
		$headerInfo = $body = null;
		if(isset($info['header_size']) and $info['header_size'] > 0) {
			$headerInfo = substr($result, 0, $info['header_size']);
			$body = substr($result, $info['header_size']);
		}
		/*GET Header With Body*/

		if(!$result)
			throw new \Exception("Url not response.");

		return [
			'header' => $headerInfo
			, 'body' => $body
		];
	}

	/*
	 * Authorization
	 * */
	public function clientAuthorize($params = null)
	{
		$response = $this->doRequest(MethodType::POST,PatternConfig::ACCESS_TOKEN,$params);
		return $response;
	}

	public function authorize($params = null)
	{
		$response = $this->doRequest(MethodType::GET,PatternConfig::AUTHORIZE,$params);
		return $response;
	}

	/*
	 * Use Only Get Pattern
	 * */
	public function get($pattern = null,$params = null)
	{
		if($pattern == PatternConfig::AUTHORIZE or $pattern == PatternConfig::ACCESS_TOKEN)
			throw new \Exception("Not allowed pattern.");

		$response = $this->doRequest(MethodType::GET,$pattern,$params);
		return $response;
	}

	/*
	 * Use Only Post Pattern
	 * */
	public function post($pattern = null,$params = null)
	{
		if($pattern == PatternConfig::AUTHORIZE or $pattern == PatternConfig::ACCESS_TOKEN)
			throw new \Exception("Not allowed pattern.");

		$response = $this->doRequest(MethodType::POST,$pattern,$params);
		return $response;
	}

	/*
	 * Use Only Del Pattern
	 * */
	public function del($pattern = null,$params = null)
	{
		if($pattern == PatternConfig::AUTHORIZE or $pattern == PatternConfig::ACCESS_TOKEN)
			throw new \Exception("Not allowed pattern.");

		$response = $this->doRequest(MethodType::DEL,$pattern,$params);
		return $response;
	}

	/*
	 * Use Only Subscribe Pattern
	 * */
	public function subscribe($pattern = null,$params = null)
	{
		if($pattern == PatternConfig::AUTHORIZE or $pattern == PatternConfig::ACCESS_TOKEN)
			throw new \Exception("Not allowed pattern.");

		$response = $this->doRequest(MethodType::GET,$pattern,$params);
		return $response;
	}

}