<?php
namespace Oauth2r\Examples;

use Oauth2r\Instagram\Library\InstagramClient;

spl_autoload_register(function ($className) {
	$baseClass = explode('Oauth2r\\',$className);

	$filename = __DIR__."/" . implode('/',$baseClass) . ".php";
	//var_dump($filename);
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
	if($getRandomClientData['code'] !== null)
		exit;

	$instagramClient = new InstagramClient($getRandomClientData['client_id'],$getRandomClientData['client_secret'],$getRandomClientData['callback_url'],true);
	$instagramClient->authorize(['scope' => $getRandomClientData['scope']]);

} catch( \Exception $e) {
	var_dump($e->getMessage());
}