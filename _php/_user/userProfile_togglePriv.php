<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_users_create');


$userId = $_POST['userId'];
$priv = $_POST['priv'];

//------------------------------------
//  Find the current privilege level
//------------------------------------

$sql = "SELECT ".$priv." 
			FROM dimli.user 
			WHERE id = ".$userId." 
			LIMIT 1 ";

$result = db_query($mysqli, $sql);

while ($row = $result->fetch_assoc()):

	// Determine the privilege's NEW value

	$value = $row[$priv];

	if ($value == '1'):
		$newValue = '0'; 
	
	elseif ($value == '0'):
		$newValue = '1';
	
	endif;

endwhile;

//------------------------------
//  Update the privilege level
//------------------------------

$sql = "UPDATE dimli.user 
			SET ".$priv." = {$newValue}
			WHERE id = ".$userId;

$result = db_query($mysqli, $sql); ?>

<script>

	$('div.priv_wrapper[id=<?php echo $priv;?>]').each(
		function()
		{
			var wrapper = $(this);
			var userId = '<?php echo $userId;?>';
			var priv = $(this).attr('id');
			userProfile_readPriv(wrapper, userId, priv);
		});

	msg(['Privilege updated'], 'success');

</script>