<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_read');

$userId = $_POST['data']['userId'];
$fName = sql_prep(trim($_POST['data']['userProf_firstName']));
$lName = sql_prep(trim($_POST['data']['userProf_lastName']));
$username = sql_prep(trim($_POST['data']['userProf_username']));

$sql = "SELECT * 
			FROM dimli.user 
			WHERE username = '{$username}' 
				AND id != '{$userId}' ";

$result = db_query($mysqli, $sql);

$username_conflicts = $result->num_rows;

if ($username_conflicts > 0):
// Another userId has already claimed the submitted username ?>

	<script>

		msg(['The username you have selected is already taken','Please chose another'], 'error');

	</script>

<?php
else:

	$sql = "UPDATE dimli.user 
				SET first_name = '{$fName}', 
					last_name = '{$lName}', 
					username = '{$username}' 
				WHERE id = '{$userId}' ";

	$result = db_query($mysqli, $sql); ?>

	<script>

		usersBrowse_load();
		userProfile_load(<?php echo $userId;?>);

		msg(['User name(s) successfully updated','Enjoy your new identity!'], 'success');

	</script>

<?php
endif;