<?php


namespace update;

abstract class _ {
	function __construct(){
		$cfg = array();
		$root_folder = dirname(dirname(__FILE__));
		chdir($root_folder);
		$root_folder = $root_folder . DIRECTORY_SEPARATOR;

		$errorFolder = $root_folder . "update" . DIRECTORY_SEPARATOR . "logs";
		$errorFile = $errorFolder . DIRECTORY_SEPARATOR . "php-".date("Y-m") . ".log";
		ini_set("error_log", $errorFile);


		$cfg = array();
		require($root_folder.'config.default.inc.php');
		if (file_exists($root_folder."config.inc.php")) {
			require($root_folder.'config.inc.php');
		}


		$this->cfg = $cfg;
		$this->root = $root_folder;
		$this->heading_padding = 50;

	}

	function heading($heading,$level=3){
		$str = PHP_EOL;
		$heading = " " . $heading . " ";

		switch ($level){
			case 1:
				$str .= "* " . $heading.PHP_EOL;
				$str .= str_pad("-", $this->heading_padding, "-", STR_PAD_BOTH);
				break;
			case 2:
				$str .= PHP_EOL;
				$str .= " * " . $heading.PHP_EOL;
				$str .= str_pad("-", $this->heading_padding, "-", STR_PAD_BOTH);

				break;
			default:
				$str .= str_pad($heading, $this->heading_padding, "-", STR_PAD_BOTH);

				break;
		}




		return $this->output($str);
	}
	function output($str){

		$str = $str . PHP_EOL;


		if (php_sapi_name() != 'cli'){
			$str = str_replace(PHP_EOL, "</br>", $str);
		}
		return $str;
	}

	abstract function update();



}