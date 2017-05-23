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




		echo $this->heading("FILES",2);

		echo $this->heading("Git Start");
		echo $this->output($this->_git_init());
		echo $this->heading("Git Pull");
		echo $this->output($this->_git_pull());



	}
	private function _git_init(){
		$return = "";
		if (!file_exists($this->root."\\.git")) {
			echo $this->output(shell_exec('git init 2>&1 &'));
		} else {
			echo $this->output(shell_exec('git reset --hard HEAD 2>&1 &'));
			echo $this->output(shell_exec('git stash 2>&1 &'));
		}
	}
	private function _git_pull(){
		echo $this->output(shell_exec('git pull https://'.$this->cfg['git']['username'] .':'.$this->cfg['git']['password'] .'@'.$this->cfg['git']['path'] .' ' . $this->cfg['git']['branch'] . ' 2>&1 &'));
	}



}