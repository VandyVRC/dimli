<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

$workNum = $_GET['json']['workNum'];
$workNum_trim = ltrim($workNum, '0');

$imageNum = $_GET['json']['imageNum'];
$imageNum_trim = ltrim($imageNum, '0');

if (strlen($workNum) >= 6 && strlen($imageNum) >= 6)
{
	$query = " UPDATE dimli.image
				SET related_works = ''
				WHERE id = {$imageNum_trim} ";
	// echo $query.'<br>';
	$result_killWorkAssoc = mysql_query($query, $connection); confirm_query($result_killWorkAssoc);
	// Remove this work number from the related_works field in the image record

	$pref = mysql_result(mysql_query("SELECT preferred_image FROM dimli.work WHERE id = {$workNum_trim}", $connection), 0);

	$query = " UPDATE dimli.work
				SET 
					related_images = REPLACE(related_images, '{$imageNum}', '')";
	$query .= ($imageNum == $pref) ? ", preferred_image = ''" : '';
	$query .= " WHERE id = {$workNum_trim} ";
	// echo $query.'<br>';
	$result_killImageAssoc = mysql_query($query, $connection); confirm_query($result_killImageAssoc);
	// Remove this image number from the related_images field in the work record

	$query = " UPDATE dimli.work
				SET related_images = REPLACE(related_images, ',,', ',')
				WHERE id = {$workNum_trim} ";
	// echo $query.'<br>';
	$result_stripDupCommas = mysql_query($query, $connection); confirm_query($result_stripDupCommas);
	// Remove the left over commas where image number was removed from a list

	$query = " UPDATE dimli.work
				SET related_images = TRIM(BOTH ',' FROM related_images)
				WHERE id = {$workNum_trim} "; 
	// echo $query.'<br>';
	$result_trimLeadingComma = mysql_query($query, $connection); confirm_query($result_trimLeadingComma);
	// Remove leading comma from the string, if there is one
}

$_SESSION['workNum'] = 'None';
?>