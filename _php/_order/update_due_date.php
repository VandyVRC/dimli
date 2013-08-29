<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_orders_create');

$newDueDate = $_POST['newDueDate'];
$orderNum = ltrim($_POST['orderNum'], '0');

$sql = "UPDATE dimli.order
			SET date_needed = '{$newDueDate}'
			WHERE id = '{$orderNum}' ";

if ($result = db_query($mysqli, $sql)) { ?>
	<script>msg(['Due date successfully updated'], 'success');</script>
<?php
} ?>