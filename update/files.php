<?php


namespace update;

class files extends _ {
	private static $instance;
	function __construct(){

		parent::__construct();

	}
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	function update(){


		echo $this->heading("FILES",true);

		echo $this->heading("Git Start");
		echo $this->output($this->_git_init());
		echo $this->heading("Git Pull");
		echo $this->output($this->_git_pull());



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
		return $return;
	}
	private function _git_pull(){
		$output = shell_exec('git pull https://'.$this->cfg['git']['username'] .':'.$this->cfg['git']['password'] .'@'.$this->cfg['git']['path'] .' ' . $this->cfg['git']['branch'] . ' 2>&1');
		$output .= PHP_EOL;
		return $output;
	}



}