<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_read');

$userId = $_POST['userId'];

$sql = "SELECT *
			FROM $DB_NAME.user
			WHERE id = '{$userId}'
			LIMIT 1 ";

$result = db_query($mysqli, $sql);

while ($user = $result->fetch_assoc()):

	$username = $user['username'];
	$firstname = $user['first_name'];
	$lastname = $user['last_name'];
	$email = $user['email'];
	$department = $user['department'];
	$userType = $user['pref_user_type'];
	$created = date('M j, Y', strtotime($user['date_created']));
	$updated = date('M j, Y', strtotime($user['last_update']));
	$priv_digitize = $user['priv_digitize'];
	$priv_edit = $user['priv_edit'];
	$priv_exportImages = $user['priv_exportImages'];
	$priv_deliver = $user['priv_deliver'];
	$priv_catalog = $user['priv_catalog'];
	$priv_approve = $user['priv_approve'];
	$priv_users_read = $user['priv_users_read'];
	$priv_users_create = $user['priv_users_create'];
	$priv_users_delete = $user['priv_users_delete'];
	$priv_orders_read = $user['priv_orders_read'];
	$priv_orders_create = $user['priv_orders_create'];
	$priv_orders_confirmCreation = $user['priv_orders_confirmCreation'];
	$priv_orders_download = $user['priv_orders_download'];
	$priv_orders_delete = $user['priv_orders_delete'];
	$priv_csv_import = $user['priv_csv_import'];
	$priv_csv_export = $user['priv_csv_export'];
	$priv_images_delete = $user['priv_images_delete'];
	$priv_images_flag4Export = $user['priv_images_flag4Export'];

endwhile; ?>

<div id="userProf_wrapper" 
	style="padding: 0;">

	<p id="userProf_name" 
		class="mediumWeight">

		<?php echo $firstname.' '.$lastname; ?>

	</p>

	<hr>

	<!-- 
			UPDATE INFO
	 -->

	<p id="userProf_name" 
		class="mediumWeight">Update info</p>

	<div class="inline label">First name:</div>

	<input type="text"
		id="userProf_firstName"
		name="userProf_firstName"
		placeholder=""
		maxlength="25"
		value="<?php echo htmlentities($firstname);?>">

	<br>

	<div class="inline label">Last name:</div>

	<input type="text"
		id="userProf_lastName"
		name="userProf_lastName"
		placeholder=""
		maxlength="25"
		value="<?php echo htmlentities($lastname);?>">

	<br>

	<div class="inline label">Username:</div>

	<input type="text"
		id="userProf_username"
		name="userProf_username"
		placeholder=""
		maxlength="15"
		value="<?php echo htmlentities($username);?>">

	<br>

	<div class="inline label">Email:</div>

	<input type="text"
		id="userProf_email"
		name="userProf_email"
		placeholder=""
		maxlength="50"
		value="<?php echo htmlentities($email);?>">

	<br>

	<div class="inline label">Department:</div>

	<select id="userProf_department"
		name="userProf_department">

                <option value="Library"
                        <?php echo ($department == 'Library')
                                ? "selected" : ""; ?>
                        >Library</option>



		<option value="History of Art"
			<?php echo ($department == 'History of Art') 
				? "selected" : ""; ?>
			>History of Art</option>

		<option value="Classical Studies"
			<?php echo ($department == 'Classical Studies') 
				? "selected" : ""; ?>
			>Classical Studies</option>

		<option value="Other"
			<?php echo ($department == 'Other') 
				? "selected" : ""; ?>
			>Other</option>

	</select>

	<br>

	<div class="inline label">User Type:</div>

	<select id="userProf_userType"
		name="userProf_userType">

		<option value="end_user"
			<?php echo ($userType == 'end_user')
				? "selected" : ""; ?>
			>End User</option>

		<option value="cataloger"
			<?php echo ($userType == 'cataloger')
				? "selected" : ""; ?>
			>Staff</option>

	</select>

	<br>

	<button type="button"
		id="userProf_updateName_submit"
		class="">Save</button>

	<p class="clear"></p>

	<hr>

	<!-- 
			CHANGE PASSWORD
	 -->

	<p id="userProf_name" class="mediumWeight">Change password</p>

	<div class="inline label">Old password:</div>

	<input type="password"
		id="userProf_oldPass"
		name="userProf_oldPass"
		placeholder="Old password"
		maxlength="15"
		value="">

	<br>

	<div class="inline label">New password:</div>

	<input type="password"
		id="userProf_newPass"
		name="userProf_newPass"
		placeholder="New password"
		maxlength="15"
		value="">

	<br>

	<button type="button"
		id="userProf_updatePass_submit"
		class="">Save</button>

	<p class="clear"></p>

	<hr>

	<!-- 
			MANAGE PRIVILEGES
	 -->

	<p id="userProf_name" 
		class="mediumWeight">Manage privileges</p>

	<div id="userProf_privs">

		<!-- 
				ADMIN
		 -->

		<div class="priv_header inline label">Admin</div><br>

		<div class="inline label">Create Users:</div>
		<div id="priv_users_create" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">View Users:</div>
		<div id="priv_users_read" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Delete Users:</div>
		<div id="priv_users_delete" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Import Data:</div>
		<div id="priv_csv_import" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Export Data:</div>
		<div id="priv_csv_export" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<!-- 
				CURATING
		 -->

		<div class="priv_header inline label">Curating</div><br>

		<div class="inline label">Catalog Records:</div>
		<div id="priv_catalog" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Approve Cataloging:</div>
		<div id="priv_approve" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Flag Images for Export:</div>
		<div id="priv_images_flag4Export" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Delete Works &amp; Images:</div>
		<div id="priv_images_delete" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<!-- 
				ORDERS
		 -->

		<div class="priv_header inline label">Orders</div><br>

		<div class="inline label">Create Orders:</div>
		<div id="priv_orders_create" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Confirm Order Creation:</div>
		<div id="priv_orders_confirmCreation" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">View Orders:</div>
		<div id="priv_orders_read" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Deliver Orders:</div>
		<div id="priv_deliver" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Download Orders:</div>
		<div id="priv_orders_download" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Delete Orders:</div>
		<div id="priv_orders_delete" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<!-- 
				DIGITIZATION
		 -->

		<div class="priv_header inline label">Digitization</div><br>

		<div class="inline label">Digitize:</div>
		<div id="priv_digitize" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Edit &amp; Retouch:</div>
		<div id="priv_edit" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

		<div class="inline label">Archive Image Files:</div>
		<div id="priv_exportImages" class="priv_wrapper">
			<div class="priv_left"></div>
			<div class="priv_right"></div>
		</div><br>

	</div>

</div>

<script>

	//-------------------------
	//  Load privilege values
	//-------------------------

	$('div.priv_wrapper').each(
		function()
		{
			var wrapper = $(this);
			var userId = '<?php echo $userId;?>';
			var priv = $(this).attr('id');
			userProfile_readPriv(wrapper, userId, priv);
		});


	//---------------------------
	//  Toggle privilege value
	//---------------------------

	$('div.priv_wrapper').click(
		function()
		{
			var wrapper = $(this);
			var userId = '<?php echo $userId;?>';
			var priv = $(this).attr('id');
			userProfile_togglePriv(wrapper, userId, priv);
		});


	//--------------------
	//  Update username
	//--------------------

	$('button#userProf_updateName_submit')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button')
					.click(
						function()
						{
							$('button#conf_button').remove();
							var userId = '<?php echo $userId;?>';
							userProfile_updateNames(userId);
						});
			});


	//--------------------
	//  Change password
	//--------------------

	$('button#userProf_updatePass_submit')
		.click(promptToConfirm)
		.click(
			function()
			{
				$('button#conf_button')
					.click(
						function()
						{
							$('button#conf_button').remove();
							var userId = '<?php echo $userId;?>';
							userProfile_changePassword(userId);
						});
			});

</script>
