<?php
$cfg['DB']['host'] = "localhost";
$cfg['DB']['username'] = "";
$cfg['DB']['password'] = "";
$cfg['DB']['database'] = "gamequery";

$cfg['git'] = array(
	'username'=>"",
	"password"=>"",
	"path"=>"github.com/WilliamStam/UpdateScript",
	"branch"=>"master"
);

$cfg['media'] = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR. "media" . DIRECTORY_SEPARATOR;
$cfg['backup'] = $cfg['media'] . "backups" . DIRECTORY_SEPARATOR;
