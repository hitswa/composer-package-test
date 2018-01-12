<?php

/************** REMOTE SERVER ENVIORNMENT ********************/


$GLOBALS['debugging'] = true;

if($GLOBALS['debugging']==true) {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
} else {
	error_reporting(0);
	ini_set("display_errors", 0);
}

// server database configrations
$GLOBALS['db_host'] = ""; // add hostname
$GLOBALS['db_user'] = ""; // add database username
$GLOBALS['db_pass'] = ""; // add database password
$GLOBALS['db_name'] = ""; // add database name

// Enviornment
$GLOBALS['root_url']  = ""; // certain variables which cn be used globally

?>