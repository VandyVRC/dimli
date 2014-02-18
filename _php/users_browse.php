<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_read');

$sql = "SELECT * 
			FROM $DB_NAME.user 
			ORDER BY last_name ASC ";

$result = db_query($mysqli, $sql); ?>

<p class="mediumWeight center_text purple">Click on a user below to view their profile</p>

<div style="padding: 0 5px 5px 5px;">

	<?php
	while ($user = $result->fetch_assoc())
	{ ?>
	
		<div class="userRow defaultCursor">

			<div class="userRow_id" hidden><?php echo $user['id'];?></div>

			<div class="userRow_name mediumWeight"><?php echo $user['last_name'].', '.$user['first_name']; ?></div>

			<div class="userRow_username"><?php echo $user['username']; ?></div>

			<img class="userRow_deleteUser floatRight pointer faded"
				src="_assets/_images/delete_v2.png"
				title="Delete <?php echo $user['username']; ?>">

		</div>

	<?php
	} ?>

</div>

<script>

	// Default: 
	// Hide all delete icons

	$('img.userRow_deleteUser').hide();

	// Bind events:
	// Hover over user row to display its delete icon
	// Click on a user's entry row to load their profile

	$('div.userRow').hover(
		function()
		{
			$(this).find('img.userRow_deleteUser').show();
		}, 
		function()
		{
			$(this).find('img.userRow_deleteUser').hide();
		})
	.click(
		function()
		{
			var userId = $(this).find('div.userRow_id').text();
			userProfile_load(userId);
		});

	// Bind event:
	// Click on the delete icon to remove the user
	$('img.userRow_deleteUser').click(
		function(event)
		{
			event.stopPropagation();
			var row = $(this).parent('div.userRow');
			var userId = row.find('div.userRow_id').text();
			var username = row.find('div.userRow_name').text();
			if (confirm("You really wish to delete "+username+"?")) {
				deleteUser_submit(userId);
			}
		});

</script>