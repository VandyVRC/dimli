<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_read');

$userId = $_POST['data']['userId'];
$opw = crypt(trim(sql_prep($_POST['data']['userProf_oldPass'])), SALT);
$npw_raw = $_POST['data']['userProf_newPass'];
$npw = crypt(trim(sql_prep($_POST['data']['userProf_newPass'])), SALT);

//---------------------------------
//  Find user's existing password
//---------------------------------

$sql = "SELECT crypted_password 
			FROM dimli.user 
			WHERE id = '{$userId}' 
			LIMIT 1 ";

$result = db_query($mysqli, $sql);

while ($row = $result->fetch_assoc()):
	$existing_pw = $row['crypted_password'];
endwhile;

if ($opw === $existing_pw):
// Entered old password matches the database

	if (strlen($npw_raw) >= 6 && strlen($npw_raw) <= 15):
	// New password is a valid length
	
		$sql = "UPDATE dimli.user 
					SET crypted_password = '{$npw}' 
					WHERE id = '{$userId}' ";

		$result = db_query($mysqli, $sql); ?>

		<script>

			// Clear inputs
			$('input#userProf_oldPass').val('');
			$('input#userProf_newPass').val('');

			msg(['User password has been successfully updated'], 'success');

		</script>

	<?php
	else: // Length of new password is invalid ?>

		<script>

		// Display error feedback on 'New password' input
			input_error($('input#userProf_newPass'));

			msg(['Your new password must be between six and fifteen characters long'], 'error');

		</script>

	<?php
	endif;

else: // The entered old password DOES NOT MATCH the database ?>

	<script>

		// Display error feedback on 'Old password' input
		input_error($('input#userProf_oldPass'));
		// Clear field values, and place cursor in 'Old password' input
		$('input#userProf_oldPass').val('').focus();
		$('input#userProf_newPass').val('');

		msg(['The old password you entered does not match the password on file'], 'error');

	</script>

<?php
endif;