<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');

$errors = array(); 
$status = false;

//  If user is already logged in, redirect to the homepage

if (logged_in()) {
	header('Location: index.php');
	exit;
}

//  The below script runs when a user attempts to log in

if (isset($_POST['login'])) {

	// Validate required fields
	$required_fields = array('username','password');
	$errors = array_merge($errors, check_required_fields($required_fields));
	
	// Validate field lengths
	$fields_with_lengths = array('username' => 15, 'password' => 15);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
	
	// Sanitize data
	$username = trim($mysqli->real_escape_string($_POST['username']));
	$password = crypt(trim($mysqli->real_escape_string($_POST['password'])), SALT);

	if (empty($errors)) { //  User-submitted data is valid, so continue
			
		//-----------------------------------------------
		//  Check user credentials against the database
		//-----------------------------------------------

		$sql = "SELECT * FROM dimli.user 
					WHERE username = '{$username}' 
						AND crypted_password = '{$password}' ";

		$result = db_query($mysqli, $sql);
		
		if ($result->num_rows === 1) {

			// One, and ONLY one, match was found
			
			$found_user = $result->fetch_assoc();

			//----------------------------------------------
			//  Load user info, preferences and privileges 
			//  and save them to the session
			//----------------------------------------------

			$_SESSION['user_id'] = $found_user['id'];

			foreach (array(
					'username',
					'first_name',
					'last_name',
					'display_name',
					'pref_lantern_view',
					'pref_user_type',
					'priv_digitize',
					'priv_edit',
					'priv_exportImages',
					'priv_deliver',
					'priv_catalog',
					'priv_approve',
					'priv_users_read',
					'priv_users_create',
					'priv_users_delete',
					'priv_orders_read',
					'priv_orders_create',
					'priv_orders_confirmCreation',
					'priv_orders_download',
					'priv_orders_delete',
					'priv_csv_import',
					'priv_csv_export',
					'priv_images_delete',
					'priv_images_flag4Export'
					) as $type)
			{
				$_SESSION[$type] = $found_user[$type];
			}

			//  Redirect the user to the homepage
			
			header('Location: index.php');
			exit();
			
		} else { // Username/password combination not found

			$status = 'badcombo';
			
		}
		
	} else { // Errors occurred

		$status = 'invalidentry';

	}

} else { // Login form has not yet been submitted.

	$username = '';
	$password = '';

}

##############################################################
###################   BEGIN CLIENT SIDE   ####################
##############################################################
require("_php/header.php"); ?>

<div id="message_wrapper">
	<div id="message_text"></div>
</div>
	
<div class="module">

	<h1>Log in</h1>

	<form action="login.php" method="post">

		<input type="text" 
			id="username" 
			name="username" 
			placeholder="username"
			value="<?php echo htmlentities($username); ?>" 
			maxlength="15">

		<br>

		<input type="password" 
			id="password" 
			name="password"
			placeholder="password" 
			value="" 
			maxlength="15">

		<br>
		
		<input type="submit" 
			name="login" 
			value="Submit">

	</form>

</div>

<script>

	<?php
	if ($status == 'badcombo'):
	// Incorrect username/password combination entered ?>

		input_error($('input#username, input#password'));
		msg(['Incorrect username & password combination'], 'error');

	<?php
	elseif ($status == 'invalidentry'):

		if (in_array('username', $errors)): ?>

			input_error($('input#username'));

		<?php 
		endif;

		if (in_array('password', $errors)): ?>
		
			input_error($('input#password'));
		
		<?php
		endif; ?>

		msg(['Both username and password must be between','six and fifteen charcters in length'], 'error');

	<?php
	endif; ?>

	$(document).ready(
		function()
		{
			if ($('div#message_text').text() == '') {
				$('input#username').focus();
			}
		});

	$('input').focus(
		function()
		{
			$(this).next('span.helper').fadeIn(50);
		})
	.blur(
		function()
		{
			$(this).next('span.helper').fadeOut(50);
		});

</script>

<?php
require("_php/footer.php");
?>