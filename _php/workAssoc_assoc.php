<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

$workNum = create_six_digits($_GET['json']['workNum']);
$shortWorkNum = ltrim($workNum, '0');

$imageNum = create_six_digits($_GET['json']['imageNum']);
$shortImageNum = ltrim($imageNum, '0');

// Set the image record's associated work
$sql = "UPDATE $DB_NAME.image 
			SET related_works = '{$workNum}' 
			WHERE id = '{$shortImageNum}' ";

$updateImage_result = db_query($mysqli, $sql);

// Add the image to the work record's list of associated images
$sql = "UPDATE $DB_NAME.work 
			SET related_images = CONCAT(related_images, ',{$imageNum}') 
			WHERE id = '{$shortWorkNum}' ";

$updateWork_result = db_query($mysqli, $sql);

// Remove the left over commas where image number was removed from a list
$sql = "UPDATE $DB_NAME.work
			SET related_images = REPLACE(related_images, ',,', ',')
			WHERE id = '{$shortWorkNum}' ";

$result_stripDupCommas = db_query($mysqli, $sql);

// Remove leading comma from the string, if there is one
$sql = "UPDATE $DB_NAME.work
			SET related_images = TRIM(LEADING ',' FROM related_images)
			WHERE id = '{$shortWorkNum}' ";

$result_trimLeadingComma = db_query($mysqli, $sql);

$_SESSION['workNum'] = $workNum;