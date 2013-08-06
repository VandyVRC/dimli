<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_read');

$query = " SELECT * FROM dimli.user ORDER BY last_name ASC ";
$result = mysql_query($query, $connection); confirm_query($result);

?>
<p class="mediumWeight center_text purple">Click on a user below to view their profile</p>

<div style="padding: 0 5px 5px 5px;">

<?php
while ($user = mysql_fetch_assoc($result))
{
	?><div class="userRow pointer">

		<div class="userRow_id" hidden><?php echo $user['id'];?></div>

		<div class="userRow_name mediumWeight"><?php echo $user['last_name'].', '.$user['first_name']; ?></div>

		<div class="userRow_username"><?php echo $user['username']; ?></div>

	</div><?php
}
?>

</div>

<script>

$('div.userRow').click(
	function()
	{
		var userId = $(this).find('div.userRow_id').text();
		userProfile_load(userId);
	});

</script>