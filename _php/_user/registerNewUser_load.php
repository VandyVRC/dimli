<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_create'); ?>

<div>
	
	<p class="instructions center_text">Enter information about the new user</p>

	<form id="registerNewUser">

		<div class="inline label">First name:</div>

		<input type="text"
			name="first_name"
			maxlength="25"
			value=""><br>

		<div class="inline label">Last name:</div>

		<input type="text"
			name="last_name"
			maxlength="25"
			value=""><br>

		<div class="inline label">Type:</div>

		<select name="user_type">

			<option value="end_user">End User</option>
			<option value="cataloger">Staff</option>

		</select><br>

		<div class="inline label">Username:</div>

		<input type="text"
			name="username"
			maxlength="15"
			value=""><br>

		<div class="inline label">Password:</div>

		<input type="password"
			name="password"
			maxlength="15"
			value=""><br>

		<button type="button" 
			id="registerNewUser_submit"
			>Submit</button>

	</form>

</div>

<script>

// Provide error feedback if special characters 
// are entered into the username input field
$('input[name=username]').keyup(noSpecialChars);

$('#registerNewUser_submit').click(
	function()
	{
		if (noSpecialChars === false) {
			return false;
		}
		else if (noSpecialChars() === true) {
			alert("No special chars!");
		}
	});

</script>