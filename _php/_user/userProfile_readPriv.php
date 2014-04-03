<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_users_read');

$userId = $_POST['userId'];
$priv = $_POST['priv'];

$sql = "SELECT ".$priv." 
			FROM $DB_NAME.user 
			WHERE id = ".$userId." 
			LIMIT 1 ";

$result = db_query($mysqli, $sql);

while ($row = $result->fetch_assoc()):
	
	$priv = $row[$priv];

	echo $priv;

endwhile; 
