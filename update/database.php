<?php


namespace update;
class database extends _ {
	private static $instance;
	function __construct(){
		parent::__construct();

		$this->link = mysqli_connect($this->cfg['DB']['host'], $this->cfg['DB']['username'], $this->cfg['DB']['password'], $this->cfg['DB']['database']);

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$this->db_version = 0;
		$this->updates = false;



	}
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	function update(){





		echo $this->heading("DATABASE",2);

		echo $this->heading("Version");
		$this->_get_version();


		echo $this->heading("Changes");
		$this->_get_updates();


		if ($this->updates){
			echo $this->heading("Backing up Database");
			$this->_backup();

			echo $this->heading("Updating Database");
			$this->_update();

		}




	}
	private function _backup(){
		$output = "";

		if (!file_exists($this->cfg['backup'])) {
			@mkdir($this->cfg['backup'], 0777, true);
			echo $this->output(" - Folder: Created");

		} else {
			echo $this->output(" - Folder: OK");
		}
		$compressprogpath = "C:\\Program Files\\7-Zip\\7z.exe";

		$filename = date("Y_m_d_H_i_s") . "_update". ".sql";
		$compress = file_exists($compressprogpath);
		if ($compress){
			$filename = $filename.".7z";
			echo $this->output(" - Compression: TRUE");
		} else {
			echo $this->output(" - Compression: FALSE");
		}



		$filepath = $this->cfg['backup'] .$filename;
		echo $this->output(" - Starting Backup: $filename");
		echo $this->output("");





		$dbhost = $this->cfg['DB']['host'];
		$dbuser = $this->cfg['DB']['username'];
		$dbpwd = $this->cfg['DB']['password'];
		$dbname = $this->cfg['DB']['database'];

		$cmd = 'mysqldump --opt --debug-check --verbose --host='.$dbhost.' --user='.$dbuser.' --password='.$dbpwd.' '.$dbname;
		if ($compress){
			$cmd .= ' | "'.$compressprogpath.'" a -si '.$filepath.'';
		} else {
			$cmd .= ' > '.$filepath.'';
		}

		$cmd .= ' 2>&1 &';

		system($cmd, $output);
		if ($compress){
			echo $this->output("");
			echo $this->output("");
		}

		if($output != 0) {
			echo  $this->output('Error during backup');
		} else {
			echo  $this->output('Database SAVED');
		}
		echo $this->output("");

		return $output;
	}
	private function _update(){
		$output = "";
		$i = 0;
		$c = 0;
		foreach ($this->sql_changes as $item){
			$i = $i+1;
			if ($i>$this->db_version){
				$c = $c+1;
				echo $this->output(" * updating: $i");
				mysqli_query($this->link,$item) or die(mysqli_error($this->link));
				$this->db_version = $i;
				//mysqli_query($this->link,"UPDATE system SET `value`='{$i}' WHERE `system`='db_version'") or die(mysqli_error($this->link));
			}

		}

		echo $this->output("$c Updates DONE");
		//$output = "";
	}
	private function _get_version(){
		$output = "";
		$sql = 'SELECT ID, system, value FROM system WHERE `system`="db_version" LIMIT 1';
		$result = mysqli_query($this->link,$sql);
		if(empty($result)) {
			echo $this->output(" - `system` table doesn't exist");
			echo $this->output(" - creating `system` table");
			mysqli_query($this->link,"CREATE TABLE IF NOT EXISTS `system` (  `ID` int(6) NOT NULL AUTO_INCREMENT,  `system` varchar(100) DEFAULT NULL,  `value` varchar(100) DEFAULT NULL,  PRIMARY KEY (`ID`))");

			mysqli_query($this->link,"INSERT INTO `system` (`system`,`value`) values ('db_version','0')");

			echo $this->output(" - re-checking db version");
			$sql = 'SELECT * FROM system WHERE `system`="db_version" LIMIT 1';
			$result = mysqli_query($this->link,$sql);

		}
		$version = $result->fetch_array();
		if (isset($version['value'])){
			$version = $version['value'];
		}
		$v = $version*1;
		$this->db_version = $v;
		echo $this->output("Current: ".$v);



	}
	private function _get_updates(){
		$output = "";

		$sql = array();
		$dir = dirname( __FILE__ );
		require_once($dir.DIRECTORY_SEPARATOR."db_update.php");
		$this->sql_changes = $sql;
		$changeCount = count($this->sql_changes);



		$currVersion = $this->db_version*1;


		if ($changeCount > $currVersion){
			$changes = $changeCount - $currVersion;
			echo $this->output( "Changes: " . $changes);
			$this->updates = true;
		} else {
			echo $this->output("Database up to date");
		}



	}



}