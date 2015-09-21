<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();

$first_name = trim($mysqli->real_escape_string($_POST['jsonData']['first_name']));
$last_name = trim($mysqli->real_escape_string($_POST['jsonData']['last_name']));
$email = trim($mysqli->real_escape_string($_POST['jsonData']['email']));
$department = trim($mysqli->real_escape_string($_POST['jsonData']['department']));
//$user_type = trim($mysqli->real_escape_string($_POST['jsonData']['user_type']));
$username = trim($mysqli->real_escape_string($_POST['jsonData']['username']));
$display_name = $first_name." ".$last_name;
$created = date('Y-m-d H:i:s');
?>
	<form id="newPatronPopulate">

		<input type="hidden" name="first_name" value="<?php echo $first_name; ?>">

		<input type="hidden" name="last_name" value="<?php echo $last_name; ?>">

		<input type="hidden" name="email" value="<?php echo $email; ?>">

		<input type="hidden" name="department" value="<?php echo $department; ?>">

		<input type="hidden" name="username" value="">

	</form>



<?php
$sql_test = "SELECT *
      FROM $DB_NAME.user";

$result_test = db_query($mysqli, $sql_test);

if ($result_test) {

while ($prev_user = $result_test->fetch_assoc()):

    if ($username === $prev_user['username']) {
    	$username = "already_in_use";

      ?>

	<script>
		registerNewPatron_inuse();
		msg(["That Username is in use. Please try another"], 'success');

	</script>

<?php

	break;
	
    }

  endwhile;

}
?>


