<?php


namespace update;
class composer extends _ {
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




		echo $this->heading("COMPOSER",2);
		echo $this->heading("Self-Update");
		echo $this->output(shell_exec('composer self-update'));

		echo $this->heading("Updated");
		echo $this->output(shell_exec('composer install'));



	}




}