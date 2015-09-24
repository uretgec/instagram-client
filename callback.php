<?php
/** 
 * User: Tuna
 * Date: 22.09.2015
 * Time: 23:57
 * Company: Uretgec
 * URI: www.uretgec.com
 */
include "Instagram/Library/YamlDumper.php";

try {
	$client = $code = null;
	if(isset($_GET['client']))
		$client = (string) $_GET['client'];

	if(isset($_GET['code']))
		$code = (string) $_GET['code'];

	/*Yml Parser - Exporter*/
	$parser = new \Oauth2r\Instagram\Library\YamlDumper("applications","Instagram/Config/application.yml","Instagram/Config/ApplicationConfig.php","Instagram/Backup");
	$parser->updateYml($client, ['code' => $code]);
	$parser->convert();

	echo $code;

} catch( \Exception $e) {
	var_dump($e->getMessage());
}