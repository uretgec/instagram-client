<?php
namespace Oauth2r\Examples;

use Oauth2r\Instagram\Config\PatternConfig;
use Oauth2r\Instagram\Library\InstagramClient;

spl_autoload_register(function ($className) {
	$baseClass = explode('Oauth2r\\',$className);

	$filename = __DIR__."/" . implode('/',$baseClass) . ".php";
//	var_dump($filename);
	if (file_exists($filename)) {
		include($filename);
		if (class_exists($className))
			return true;

	}
	return false;
});

try {
	/*Yml Parser - Exporter*/
	$parser = new \Oauth2r\Instagram\Library\YamlDumper("applications","Instagram/Config/application.yml","Instagram/Config/ApplicationConfig.php","Instagram/Backup");
	$parser->convert();
	echo "File created.";

} catch( \Exception $e) {
	var_dump($e->getMessage());
}