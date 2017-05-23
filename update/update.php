<?php


namespace update;

class update {
	private static $instance;
	function __construct(){

		$dir = dirname( __FILE__ );

		//parent::__construct();
		foreach(glob($dir.DIRECTORY_SEPARATOR."*.php") as $file){
			require_once($file);
		}


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