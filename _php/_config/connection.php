<?php
require('constants.inc.php');

  // Create a database connection
$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
if (!$connection) {
	die('Database connection failed: ' . mysql_error());
}

  // Select a database to use
$db_select = mysql_select_db(DB_NAME, $connection);
if (!$db_select) {
	die('Database selection failed: ' . mysql_error());
}

  // Create mysqli connection object
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
	die('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

  // Set connection charset
mysql_set_charset('utf8', $connection);

  // Set charset to UTF-8
if (!$mysqli->set_charset('utf8')) {
	die('Unable to load charset UTF-8: ' . $mysqli->error);
}

  // Set server to Central Standard Time
date_default_timezone_set('America/Chicago');
?>