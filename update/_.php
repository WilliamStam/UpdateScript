<?php


namespace update;

abstract class _ {
	function __construct(){
		$this->construct();

	}
	function construct(){
		$cfg = array();
		$root_folder = dirname(dirname(__FILE__));
		chdir($root_folder);
		$root_folder = $root_folder . DIRECTORY_SEPARATOR;

		$errorFolder = $root_folder . "update" . DIRECTORY_SEPARATOR . "logs";
		$errorFile = $errorFolder . DIRECTORY_SEPARATOR . "php-".date("Y-m") . ".log";
		ini_set("error_log", $errorFile);


		$cfg = array();
		require_once($root_folder.'config.default.inc.php');
		if (file_exists($root_folder."config.inc.php")) {
			require_once($root_folder.'config.inc.php');
		}


		$this->cfg = $cfg;
		$this->root = $root_folder;

		$this->heading_padding = 50;
	}
	function heading($heading,$main=false){
		$str = PHP_EOL;
		$heading = " " . $heading . " ";

		if ($main){
			$str .= str_pad("-", $this->heading_padding, "-", STR_PAD_BOTH).PHP_EOL;
			$str .= str_pad($heading, strlen($heading) + 6, "*", STR_PAD_BOTH).PHP_EOL;
			$str .= str_pad("-", $this->heading_padding, "-", STR_PAD_BOTH);
		} else {

			$str .= str_pad($heading, $this->heading_padding, "-", STR_PAD_BOTH);
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