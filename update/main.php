<?php


namespace update;

class main {
	function __construct(){
		$cfg = array();
		$root_folder = dirname(dirname(__FILE__));
		chdir($root_folder);
		$root_folder = $root_folder . DIRECTORY_SEPARATOR;

		$errorFolder = $root_folder . "update" . DIRECTORY_SEPARATOR . "logs";
		$errorFile = $errorFolder . DIRECTORY_SEPARATOR . "php-".date("Y-m") . ".log";
		ini_set("error_log", $errorFile);



		require_once($root_folder.'config.default.inc.php');
		if (file_exists($root_folder."config.inc.php")) {
			require_once($root_folder.'config.inc.php');
		}


		$this->cfg = $cfg;
		$this->root = $root_folder;

	}
	function files(){
		echo "Updating files...".PHP_EOL;
		echo $this->_git_init();
		echo $this->_git_pull();
	}
	private function _git_init(){
		$return = "";
		if (!file_exists($this->root."\\.git")) {
			$return .= shell_exec('git init 2>&1');
			$return .= PHP_EOL;
		} else {
			$return .= shell_exec('git reset --hard HEAD 2>&1');
			$return .= PHP_EOL;
			$return .= shell_exec('git stash 2>&1');
			$return .= PHP_EOL;
		}
		return $this->output($return);
	}
	private function _git_pull(){
		$output = shell_exec('git pull https://'.$this->cfg['git']['username'] .':'.$this->cfg['git']['password'] .'@'.$this->cfg['git']['path'] .' ' . $this->cfg['git']['branch'] . ' 2>&1');
		$output .= PHP_EOL;
		return  $this->output($output);
	}
	private function output($str){


		return $str;
	}


}