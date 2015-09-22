<?php
/** 
 * User: Tuna
 * Date: 21.09.2015
 * Time: 23:11
 * Company: Uretgec
 * URI: www.uretgec.com
 */

namespace Oauth2r\Instagram\Library;

class YamlDumper
{
	private $prefix;
	private $ymlFile;
	private $exportFile;
	private $backupFolder;

	public function __construct ($prefix, $ymlFile, $exportFile, $backupFolder)
	{
		$this->prefix = $prefix;
		$this->ymlFile = $ymlFile;
		$this->exportFile = $exportFile;
		$this->backupFolder = $backupFolder."/".uniqid().".backup";
	}

	protected function isYmlExtensionLoaded()
	{
		if(!extension_loaded("yaml"))
			throw new \Exception("Yml extension not found.");
	}

	public function convert()
	{
		$this->isYmlExtensionLoaded();

		$yamlParse = yaml_parse(file_get_contents($this->ymlFile));
		if(!isset($yamlParse[$this->prefix]))
			throw new \Exception("Prefix not found in array.");

		$application = var_export($yamlParse[$this->prefix],true);

		if(!file_exists($this->exportFile)) {
			file_put_contents($this->exportFile,"<?php return $application; ?>");
		} else {
			copy($this->exportFile,$this->backupFolder);
			file_put_contents($this->exportFile,"<?php return $application; ?>");
		}
	}

	public function updateYml($data = null)
	{
		if($data === null)
			return null;

		if(!isset($data[$this->prefix]))
			$data[$this->prefix] = $data;

		copy($this->ymlFile,$this->backupFolder);
		file_put_contents($this->ymlFile,yaml_emit($data));
	}
}