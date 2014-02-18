<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

if (isset($_POST['order']) && isset($_POST['uid']) && isset($_POST['username'])):

	$order = 	$_POST['order'];
	$uid = 		$_POST['uid'];
	$username = $_POST['username'];

	$sql = "UPDATE $DB_NAME.order 
				SET assigned_to = {$uid} 
				WHERE id = {$order} ";

	$res = db_query($mysqli, $sql); ?>

	<script id="updateCataloger_script">

		msg(['Order now assigned to <?php echo $username; ?>'], 'success');
		
	</script>

<?php endif; ?>