<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();

$work = $_POST['work'];
$image = $_POST['image'];

if ($work != 'None')
{
	$sql = "SELECT * 
				FROM dimli.title 
				WHERE related_works = {$work} LIMIT 1 ";
}
elseif ($work = 'None')
{
	$sql = "SELECT title_text 
				FROM dimli.title 
				WHERE related_images = {$image} LIMIT 1 ";
}

$result = db_query($mysqli, $sql); confirm_query($result);
while ($row = $result->fetch_assoc())
{
	$title = $row['title_text'];
}
echo (strlen($title) < 60) 
		? $title 
		: substr($title, 0, 57).'...';
?>