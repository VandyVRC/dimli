<?php

$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__').$urlpatch);}

require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_users_create'); ?>

<div>
	
	<p class="instructions center_text">Enter information about the new user</p>

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

		<div class="inline label">Type:</div>

		<select name="user_type">

			<option value="end_user">End User</option>
			<option value="cataloger">Staff</option>

		</select>

		<br>

		<div class="inline label">Username:</div>

		<input type="text"
			name="username"
			maxlength="15"
			value="">

		<br>

		<div class="inline label">Password:</div>

		<input type="password"
			name="password"
			maxlength="15"
			style="margin-bottom: 0;"
			value="">

		<br>

		<div class="inline label"></div>	

		<div class="inline" 
			style="font-size: 0.7em; margin-left: 10px;"
			>minimum 6 charcters</div>

		<br>

		<button type="button" id="registerNewUser_submit">

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
			 form.elements.password.value.trim() != "" &&
			 form.elements.password.value.trim().length >= 6 &&
			 noSpecialChars(usernameInput);
}

// Bind event:
// Submits the form if none of the form fields contain errors

$('#registerNewUser_submit').click(
	function()
	{
		var form = document.getElementById("registerNewUser");

		if (registerNewUser_valid(form)) {

			registerNewUser_submit('registerNewUser');
		} 
		else {

			msg(["Please correct errors before submitting"], "error");
		}
	});

</script>
