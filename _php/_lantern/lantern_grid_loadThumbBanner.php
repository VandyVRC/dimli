<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();

$work = $_POST['work'];
$image = $_POST['image'];

if ($work != 'None') {
	$sql = "SELECT * 
				FROM $DB_NAME.title 
				WHERE related_works = {$work} LIMIT 1 ";

} elseif ($work = 'None') {
	$sql = "SELECT title_text 
				FROM $DB_NAME.title 
				WHERE related_images = {$image} LIMIT 1 ";
}

$result = db_query($mysqli, $sql);

if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {
  	$title = $row['title_text'];
  }

  echo (strlen($title) < 60) 
  	? $title 
  	: substr($title, 0, 57).'...';

}
?>
