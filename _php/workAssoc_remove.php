<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

$workNum = $_GET['json']['workNum'];
$workNum_trim = ltrim($workNum, '0');

$imageNum = $_GET['json']['imageNum'];
$imageNum_trim = ltrim($imageNum, '0');

if (strlen($workNum) >= 6 && strlen($imageNum) >= 6)
{
	$sql = "UPDATE $DB_NAME.image
				SET related_works = ''
				WHERE id = {$imageNum_trim} ";

	$result_killWorkAssoc = db_query($mysqli, $sql);
	// Remove this work number from the related_works field in the image record


	$sql = "SELECT preferred_image 
				FROM $DB_NAME.work 
				WHERE id = {$workNum_trim} ";

	$res = db_query($mysqli, $sql);

	while ($row = $res->fetch_assoc()) {
		$pref = $row['preferred_image'];
	}


	$sql = "UPDATE $DB_NAME.work
				SET related_images = REPLACE(related_images, '{$imageNum}', '')";
	$sql .= ($imageNum == $pref) ? ", preferred_image = ''" : '';
	$sql .= " WHERE id = {$workNum_trim} ";

	$result_killImageAssoc = db_query($mysqli, $sql);
	// Remove this image number from the related_images field in the work record

	$sql = "UPDATE $DB_NAME.work
				SET related_images = REPLACE(related_images, ',,', ',')
				WHERE id = {$workNum_trim} ";

	$result_stripDupCommas = db_query($mysqli, $sql);
	// Remove the left over commas where image number was removed from a list

	$sql = "UPDATE $DB_NAME.work
				SET related_images = TRIM(BOTH ',' FROM related_images)
				WHERE id = {$workNum_trim} "; 

	$result_trimLeadingComma = db_query($mysqli, $sql);
	// Remove leading comma from the string, if there is one
}

$_SESSION['workNum'] = 'None';

