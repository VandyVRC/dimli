<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_images_delete');

/* Proceed if work number from AJAX request is a six-digit number */
if (strlen($_POST['workNum']) == 6 && is_numeric($_POST['workNum']))
{
	/* Define variables from AJAX request */
	$work = $_POST['workNum'];
	$work_trim = ltrim($work, '0');

	$affected_records = '';

	/*
	Delete this Work record
	*/
	$deleted_res = isnerQ("DELETE FROM dimli.work WHERE id = {$work_trim}");
	// $affected_records = 'Work records affected: '.mysql_affected_rows();

	$tables = array('agent','culture','date','edition','inscription','location','material','measurements','rights','source','style_period','subject','technique','title','work_type');
	foreach ($tables as $table) {
		$res = isnerQ("DELETE FROM dimli.{$table} WHERE related_works = {$work}");
	}

	/*
	Free any Image record related to this Work
	*/
	$disassociated_res = isnerQ("UPDATE dimli.image SET related_works = '' WHERE related_works = {$work}");
	// $affected_records .= ', Image records affected: '.mysql_affected_rows();

	if ($deleted_res && $disassociated_res)
	{
	?>
	<script id="delWorRec_script">

		msg(['Work <?php echo $work; ?> successfully deleted and','disassociated from any related Image records'], 'success');

	</script>
	<?php
	}

	/*
	LOG ACTION
	*/
	$UnixTime = time(TRUE);
	$log = isnerQ("INSERT INTO dimli.Activity
						SET 
							UserID = '{$_SESSION['user_id']}',
							RecordType = 'Work',
							RecordNumber = {$work_trim},
							ActivityType = 'deleted',
							UnixTime = '{$UnixTime}'
						");
}
?>