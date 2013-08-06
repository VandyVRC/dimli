<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
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
$query = " UPDATE dimli.image 
			SET 
				related_works = '{$workNum}' 
			WHERE 
				id = '{$shortImageNum}' 
			";
$updateImage_result = mysql_query($query, $connection);
confirm_query($updateImage_result);

// Add the image to the work record's list of associated images
$query = " UPDATE dimli.work 
			SET 
				related_images = CONCAT(related_images, ',{$imageNum}') 
			WHERE 
				id = '{$shortWorkNum}'
			";
$updateWork_result = mysql_query($query, $connection);
confirm_query($updateWork_result);

// Remove the left over commas where image number was removed from a list
$query = " UPDATE dimli.work
			SET
				related_images = REPLACE(related_images, ',,', ',')
			WHERE
				id = '{$shortWorkNum}'
			";
$result_stripDupCommas = mysql_query($query, $connection);
confirm_query($result_stripDupCommas);

// Remove leading comma from the string, if there is one
$query = " UPDATE dimli.work
			SET
				related_images = TRIM(LEADING ',' FROM related_images)
			WHERE
				id = '{$shortWorkNum}'
			";
$result_trimLeadingComma = mysql_query($query, $connection);
confirm_query($result_trimLeadingComma);

$_SESSION['workNum'] = $workNum;
?>