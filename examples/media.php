<?php
namespace Oauth2r\Examples;

use Oauth2r\Instagram\Config\PatternConfig;
use Oauth2r\Instagram\Library\InstagramClient;

spl_autoload_register(function ($className) {
	$baseClass = explode('Oauth2r\\',$className);

	$filename = __DIR__."/.." . implode('/',$baseClass) . ".php";
//	var_dump($filename);
	if (file_exists($filename)) {
		include($filename);
		if (class_exists($className))
			return true;

	}
	return false;
});

try {

	/*Debug*/
	$instagramConfigs = include("../Instagram/Config/ApplicationConfig.php");
	$client = mt_rand(0,count($instagramConfigs)-1);
	$getRandomClientData = $instagramConfigs[$client];

	$instagramClient = new InstagramClient($getRandomClientData['client_id'],$getRandomClientData['client_secret'],$getRandomClientData['callback_url'],true);
	$instagramClient->setAccessToken($getRandomClientData['access_token']);
	$result = $instagramClient->get(PatternConfig::GET_MEDIA_POPULAR);
	if($instagramClient->isSuccess()) {
		var_dump($instagramClient->getData());
	} else {
		echo $instagramClient->errors();
	}

} catch( \Exception $e) {
	var_dump($e->getMessage());
}