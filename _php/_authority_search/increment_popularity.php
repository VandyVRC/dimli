<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

if (isset($_POST['table'])) {

	// Define table to be updated
	$table = $_POST['table'];

	if (in_array($table, array('getty_aat','getty_tgn','getty_ulan')))
	{
		$db_field = 'getty_id';
		$db_id = $_POST['authorityId'];
	}
	elseif (in_array($table, array('repository')))
	{
		$db_field = 'id';
		$db_id = ltrim($_POST['authorityId'], 'rep');
	}

	if (in_array($table, array('getty_aat','getty_tgn','getty_ulan','repository')))
	{
		$sql = " UPDATE DB_NAME.".$table." SET popularity = popularity + 1 WHERE ".$db_field." = '".$db_id."' ";

		$result = db_query($mysqli, $sql);

		echo 'Popularity increased';
	}
	
}

