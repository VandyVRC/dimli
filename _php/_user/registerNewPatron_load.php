<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_users_create'); 
?>

<div id="register_new_user">
	
	<p class="instructions center_text">Enter information about the new patron</p>

	<form id="registerNewUser">

		<div class="inline label">First name:</div>

		<input type="text"
			name="first_name"
			maxlength="25"
			value="">

		<br>

		<div class="inline label">Last name:</div>

		<input type="text"
			name="last_name"
			maxlength="25"
			value="">

		<br>

		<div class="inline label">Email:</div>

		<input type="text"
			name="email"
			maxlength="50"
			value="">

		<br>

		<div class="inline label">Department:</div>

		<select name="department">


            <option value="Library">Library</option>
			<option value="History of Art">History of Art</option>
			<option value="Classical Studies">Classical Studies</option>
			<option value="Other">Other</option>

		</select>

		<br>

		<input type="hidden" name="user_type" value="end_user"/>

		<div class="inline label" id="username">Username:</div>


		<input type="text" id="usernamefield" name="username" maxlength="15" value="">

		<br>

		<button type="button" id="registerNewPatron_submit">

			<span>Submit</span>

		</button>

	</form>

</div>

<script>

// Bind event:
// Provides live error feedback if special characters are entered into the username input field

$('input[name=username]').unbind("keyup").keyup(
	function()
	{
		noSpecialChars($('input[name=username]'));
	});

// Define function:
// Validates the entire form; returns a boolean

function registerNewUser_valid(form) {
	var usernameInput = $('input[name=username]');
	return form.elements.first_name.value.trim() != "" &&
			 form.elements.last_name.value.trim() != "" &&
			 form.elements.email.value.trim() != "" &&
			 form.elements.username.value.trim() != "" &&
			 noSpecialChars(usernameInput);
}

// Bind event:
// Submits the form if none of the form fields contain errors

$('#registerNewPatron_submit').click(
	function()
	{

		var form = document.getElementById("registerNewUser");

		if (registerNewUser_valid(form)) {

			registerNewPatron_submit('registerNewUser');
		} 
		else {

			msg(["Please correct errors before submitting"], "error");
		}
	});

</script>

