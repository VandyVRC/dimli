<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_users_read');

$userId = $_POST['data']['userId'];
$fName = $mysqli->real_escape_string(trim($_POST['data']['userProf_firstName']));
$lName = $mysqli->real_escape_string(trim($_POST['data']['userProf_lastName']));
$username = $mysqli->real_escape_string(trim($_POST['data']['userProf_username']));
$email = $mysqli->real_escape_string(trim($_POST['data']['userProf_email']));
$department = $mysqli->real_escape_string(trim($_POST['data']['userProf_department']));
$userType = $mysqli->real_escape_string(trim($_POST['data']['userProf_userType']));

$sql = "SELECT * 
			FROM $DB_NAME.user 
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

	$sql = "UPDATE $DB_NAME.user 
				SET first_name = '{$fName}', 
					last_name = '{$lName}', 
					username = '{$username}', 
					email = '{$email}', 
					department = '{$department}',
					pref_user_type = '{$userType}' 
				WHERE id = '{$userId}' ";

	$result = db_query($mysqli, $sql); ?>

	<script>

		usersBrowse_load();
		userProfile_load(<?php echo $userId;?>);

		msg(['User info successfully updated','Enjoy your new identity!'], 'success');

	</script>

<?php
endif;

