<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_images_flag4Export');

//------------------------------------
//	Flag / Unflag Image(s) for Export
//------------------------------------

$newStatus = $_POST['flagged_for_export'];
$imageId = $_POST['image_id'];

// Update the flagged status of the clicked image record

$query = " UPDATE dimli.image 
			SET flagged_for_export = '{$newStatus}' 
			WHERE id = '{$imageId}' ";
$result_updateFlag = mysql_query($query, $connection); 
confirm_query($result_updateFlag);

// Re-query flagged status

$query = " SELECT flagged_for_export 
			FROM dimli.image 
			WHERE id = '{$imageId}' 
			LIMIT 1 ";
$result_newStatus = mysql_query($query, $connection); 
confirm_query($result_newStatus);

while ($row = mysql_fetch_assoc($result_newStatus))
{
?>

<!--
	Header > FLAG IMAGE
-->

<div class="flagRecord_button<?php echo ($_SESSION['priv_images_flag4Export'] == '1') ? ' pointer active' : ''; echo ($row['flagged_for_export'] == 1) ? ' flagged' : ''; ?>"
	style="background-image: url(_assets/_images/flags_green.png);"
	title="<?php echo ($row['flagged_for_export'] != 1) ? 'Flag for export' : 'Clear export flag'; ?>">

</div>

<?php
}
?>
<script>

$('div.flagRecord_button.active').unbind('click');

$('div.flagRecord_button.active').click(function()
{
	var image_num = pad($.trim($(this)
						.parents('div.orderView_imageRow')
						.find('div.imageList_imageNum')
						.text()), 6);

	var status = $(this)
						.parents('div.orderView_imageRow')
						.find('div.export_flag_status')
						.text();

	updateExportFlag(image_num, status);
});

</script>