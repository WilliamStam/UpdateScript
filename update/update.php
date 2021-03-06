<?php


namespace update;

class update extends _{
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
		echo $this->heading("UPDATING ALL",1);
		if (isset($this->cfg['git'])){
			files::getInstance()->update();
		}
		if (file_exists("../composer.lock")){
			composer::getInstance()->update();
		}
		if (isset($this->cfg['DB'])){
			database::getInstance()->update();
		}
	}

}