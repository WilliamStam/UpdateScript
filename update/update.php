<?php


namespace update;

class update {
	private static $instance;
	function __construct(){
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

		$dir = dirname( __FILE__ );

		//parent::__construct();
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