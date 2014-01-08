<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_images_delete');

/* Proceed if work number from AJAX request is a six-digit number */
if (strlen($_POST['workNum']) == 6 && is_numeric($_POST['workNum']))
{
	/* Define variables from AJAX request */
	$work = $_POST['workNum'];
	$work_trim = ltrim($work, '0');

	//---------------------------
	//  Delete this Work record
	//---------------------------
	
	$sql = "DELETE FROM $DB_NAME.work 
				WHERE id = {$work_trim}";

	$deleted_res = db_query($mysqli, $sql);

	$tables = array('agent','culture','date','edition','inscription','location','material','measurements','rights','source','style_period','subject','technique','title','work_type');

	foreach ($tables as $table) {

		$sql = "DELETE FROM $DB_NAME.{$table} 
					WHERE related_works = {$work} ";

		$res = db_query($mysqli, $sql);
	}

	//----------------------------------------------
	//  Free any Image record related to this Work
	//----------------------------------------------
	
	$sql = "UPDATE $DB_NAME.image 
				SET related_works = '' 
				WHERE related_works = {$work} ";

	$disassociated_res = db_query($mysqli, $sql);

	if ($deleted_res && $disassociated_res)
	{ ?>

		<script id="delWorRec_script">

			msg(['Work <?php echo $work; ?> successfully deleted and','disassociated from any related Image records'], 'success');

		</script>

	<?php
	}

	//--------------
	//  Log action
	//--------------

	$UnixTime = time(TRUE);

	$sql = "INSERT INTO $DB_NAME.Activity
						SET UserID = '{$_SESSION['user_id']}',
							RecordType = 'Work',
							RecordNumber = {$work_trim},
							ActivityType = 'deleted',
							UnixTime = '{$UnixTime}' ";

	$result = db_query($mysqli, $sql);
}
?>
