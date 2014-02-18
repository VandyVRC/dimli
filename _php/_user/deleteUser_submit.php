<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_create');

$userId = $_POST['userId'];

$sql = "DELETE FROM $DB_NAME.user
			WHERE id = {$userId} ";

$result = db_query($mysqli, $sql);

if ($result) { ?>

 	<script>

		msg(["User successfully deleted"], 'success');

	</script>

<?php
} ?>