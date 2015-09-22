<?php
namespace Oauth2r;

use Oauth2r\Instagram\Config\PatternConfig;
use Oauth2r\Instagram\Library\InstagramClient;
use Oauth2r\Instagram\Library\YamlDumper;

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
	/*Yml Parser - Exporter*/
//	$parser = new YamlDumper("applications","Instagram/Config/application.yml","Instagram/Config/ApplicationConfig.php","Instagram/Backup");
//	$parser->convert();

	/*Debug*/
	$instagramConfigs = include("Instagram/Config/ApplicationConfig.php");
	$getRandomClientData = $instagramConfigs[mt_rand(0,count($instagramConfigs)-1)];
	$instagramClient = new InstagramClient($getRandomClientData['client_id'],$getRandomClientData['client_secret'],$getRandomClientData['callback_url'],true);
	$instagramClient->get(PatternConfig::AUTHORIZE,['scope' => $getRandomClientData['scope']]);
//	$instagramClient->get(PatternConfig::ACCESS_TOKEN,['code' => 'asdad']);
//	$instagramClient->setAccessToken("asdasd");
//	$instagramClient->get(PatternConfig::DEL_MEDIA_COMMENTS,['media_id' => '12','comment_id' => '15']);

} catch( \Exception $e) {
	var_dump($e->getMessage());
}