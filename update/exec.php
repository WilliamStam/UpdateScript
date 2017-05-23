<?php


namespace update;

class exec extends _ {
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
			files::getInstance()->update();



	}




}