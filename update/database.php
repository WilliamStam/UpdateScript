<?php


namespace update;

class database extends _ {
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


		echo $this->heading("DATABASE",true);





	}
	private function _backup(){
		$return = "";

		return $return;
	}
	private function _update_db(){
		$output = "";
		return $output;
	}



}