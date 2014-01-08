<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_users_create');

$first_name = trim($mysqli->real_escape_string($_POST['jsonData']['first_name']));
$last_name = trim($mysqli->real_escape_string($_POST['jsonData']['last_name']));
$email = trim($mysqli->real_escape_string($_POST['jsonData']['email']));
$department = trim($mysqli->real_escape_string($_POST['jsonData']['department']));
$user_type = trim($mysqli->real_escape_string($_POST['jsonData']['user_type']));
$username = trim($mysqli->real_escape_string($_POST['jsonData']['username']));
$password = crypt(trim($mysqli->real_escape_string($_POST['jsonData']['password'])), SALT);
$display_name = $first_name." ".$last_name;
$created = date('Y-m-d H:i:s');

$sql = "INSERT INTO $DB_NAME.user
			SET username = '{$username}',
				crypted_password = '{$password}',
				first_name = '{$first_name}',
				last_name = '{$last_name}',
				email = '{$email}',
				department = '{$department}',
				display_name = '{$display_name}',
				pref_user_type = '{$user_type}',
				date_created = '{$created}' ";

$result = db_query($mysqli, $sql);

if ($result) { ?>

	<script>

		msg(["User successfully created"], 'success');

	</script>

<?php
} ?>
