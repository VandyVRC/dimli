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
			value=""><br>

		<div class="inline label">Last name:</div>

		<input type="text"
			name="last_name"
			value=""><br>

		<div class="inline label">Type:</div>

		<select name="user_type">

			<option value="end_user">End User</option>
			<option value="cataloger">Staff</option>

		</select><br>

		<div class="inline label">Username:</div>

		<input type="text"
			name="username"
			value=""><br>

		<div class="inline label">Password:</div>

		<input type="password"
			name="password"
			value=""><br>

		<button type="button"
			id="registerNewUser_submit"
			>Submit</button>

	</form>

</div>

<script>
	
$('input[name=username]').keyup(
	function()
	{
		var sValue = $(this).val();
		var reNotAllowed = new RegExp(/[\.\/\s\,\!\@\#\$\%\^\&\*\(\)\'\"\;\:\<\>\`\~\-\_\=\+\{\}\[\]\|']/);
		if (sValue.search(reNotAllowed) >= 0) {
			// Display user error message
			msg(['Usernames may not contain special characters'], 'error');
			// Highlight input's background
			$(this).css({ backgroundColor: '#FFF0DE' });
		}
		else {
			// Remove user error message
			$('div#message_wrapper').hide();
			// Reset input's background color
			$(this).css({ backgroundColor: '#FFF' });
		}
	});

$('#registerNewUser_submit').click(
	function()
	{
		
	});

</script>