<?php


namespace update;

class update extends _ {
	private static $instance;
	function __construct(){

		parent::__construct();
		$dir = dirname( __FILE__ );
		foreach(glob($dir.DIRECTORY_SEPARATOR."*.php") as $file){
			if (!strpos($file,"db_update.php")){
				require_once($file);
			}

		}


	}
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	function update(){
		echo "Updating...." . PHP_EOL;
			files::getInstance()->update();
			database::getInstance()->update();



	}




}