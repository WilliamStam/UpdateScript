<?php

$dir = dirname( __FILE__ );
foreach(glob($dir.DIRECTORY_SEPARATOR."*.php") as $file){
	if (!strpos($file,"db_update.php")){
		require_once($file);
	}

}
require_once("update.php");
\update\update::getInstance()->update();
