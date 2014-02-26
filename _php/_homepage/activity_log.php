<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');

confirm_logged_in();

// Gather user's last 50 entries from activity log
$sql = "SELECT UserID, 
				RecordNumber, 
				RecordType, 
				ActivityType, 
				MAX(UnixTime) AS UnixTime
			FROM $DB_NAME.activity 
			WHERE UserID = {$_SESSION['user_id']}
			AND (ActivityType != 'viewed' 
				OR (ActivityType = 'viewed' AND RecordType = 'Order') )
			GROUP BY RecordNumber, ActivityType
			ORDER BY UnixTime DESC 
			LIMIT 50";

$activity_r = db_query($mysqli, $sql);

?>

<h3>Activity Log</h3>

<div id="activity_log">

<?php 

if ($activity_r->num_rows <= 0){
// Current user has NO ACTIVITY logged ?>

	<br>
	<p style="font-size: 0.9em; opacity: 0.6; margin-bottom: 20px;">Welcome to Dimli, <?php echo $_SESSION['first_name']; ?>.<br><br>In the future, your recent activity will be displayed here along the left-hand side of your profile page.</p>

<?php
} 

else {
// Current user DOES HAVE some activity logged ?

 	$i = 0; 

	while ($row = $activity_r->fetch_assoc()) {

	// For each logged action 

		if ($i >= 16) break; 
		// Show no more than 16 rows


		if ($row['RecordType'] == 'Order'){
		// Action was performed on an Order

			$sql = "SELECT * FROM $DB_NAME.order 
								WHERE id = {$row['RecordNumber']} ";
			
			$orderInfo = db_query($mysqli, $sql); 

		if ($orderInfo->num_rows <= 0) continue; 

				while ($order = $orderInfo->fetch_assoc()){

				$patron = (strlen($order['requestor']) > 25)
					? substr($order['requestor'], 0, 25) . '..'
					: $order['requestor'];

				$imgCount = $order['image_count'];
			}
		}


		if ($row['RecordType'] == 'Work'){
		// Action was performed on an Work 

		$sql = "SELECT preferred_image 
								FROM $DB_NAME.work 
								WHERE id = {$row['RecordNumber']} ";
			
			$workInfo = db_query($mysqli, $sql);

			while ($work = $workInfo->fetch_assoc()){

			$pref_image = $work['preferred_image'];

				$sql = "SELECT legacy_id 
						FROM $DB_NAME.image 
						WHERE id = {$work['preferred_image']}";

					$result_pref_imageId = db_query($mysqli, $sql);

					while ($row = $result_pref_imageId->fetch_assoc()){
				
				$pref_imageId = $row['legacy_id'];
				
				}
 			}	
 		}		


		if ($row['RecordType'] == 'Image') {
				// Action was performed on an Work 
					
		$sql = "SELECT legacy_id 
						FROM $DB_NAME.image 
						WHERE id = {$row['RecordNumber']} ";

					$result_LegId = db_query($mysqli, $sql);

				while ($image = $result_LegId->fetch_assoc()){
				
				$legId = $image['legacy_id'];


			$truncLeg = (strlen($legId) > 6) 
    		? substr($legId, 0, 6) . '...' 
   		: $legId;
					
				}
			}

			$recNo = ($row['RecordType']=="Order") 
			? str_pad($row['RecordNumber'], 4, '0', STR_PAD_LEFT) 
			: $row['RecordNumber'];	

		 	$str = '<span class="">';
			$str.= ($row['UserID']==$_SESSION['user_id'])
			? ' You '
			: ' -- '; 
			$str.= $row['ActivityType'].' ';
			$str.= $row['RecordType'].' ';
			
			$recNoWithLeg = ($row['RecordType']=="Order") 
			? str_pad($row['RecordNumber'], 4, '0', STR_PAD_LEFT).' ' 
			: $truncLeg.' ' ;
			
			$str.= $recNoWithLeg;
			$str.= '</span>';
			$str.= '<br><span class="" style="font-size: 0.75em; color: #999;">';
			$str.= date('Y-m-d H:i:s', $row['UnixTime']); // REVISIT 
			// Should be changed to a human-readbale timestamp 
		 	$str.= '</span>'; ?>

			<div class="row defaultCursor" 

			data-type="<?php echo $row['RecordType']; ?>"

			data-pref-image="<?php echo ($pref_image !='') 
											? $pref_imageId 
											: 'none'; ?>"
			data-id="<?php echo $recNo; ?>"><!--

			--><?php echo $str;

			if (in_array($row['RecordType'], array('Work', 'Image')) && checkRemoteFile($webroot."/_plugins/timthumb/timthumb.php?src=".$image_src."thumb/".$legId.".jpg")){ ?>

				<img src="<?php echo $webroot; ?>/_plugins/timthumb/timthumb.php?src=<?php echo $image_src; ?>thumb/<?php echo $legId; ?>.jpg&amp;h=30&amp;w=40&amp;q=90"

					style="float: right; margin-top: -15px;">

				<?php }

				else if ($row['RecordType'] == 'Order') { ?>

						<div style="float: right; margin-top: -15px;">

						<span style="display: inline; vertical-align: middle; font-size: 15px;"><?php echo $imgCount; ?></span>

						<img style="height: 25px; vertical-align: middle; margin-left: 3px;" src="_assets/_images/photos.png">

					</div>


		<?php } ?>
			
			</div>

		<?php 
		
	

		$i ++; 
	}
}
	?>

</div>

<script>

	$('div#activity_log div.row').click(
		function()
		{
			$('div#work_module').add('div#image_module').remove();

			if ($(this).attr('data-type') == 'Order')
			{
				var orderNum = $(this).attr('data-id');
				open_order($.trim(orderNum));
			}

			if ($(this).attr('data-type') == 'Image')
			{
				var imageNum = $(this).attr('data-id');
				view_image_record(imageNum);
				view_work_record(imageNum);
			}

			if ($(this).attr('data-type') == 'Work')
			{
				var imageNum = $(this).attr('data-pref-image');
				view_image_record(imageNum);
				view_work_record(imageNum);
			}
				
		});

</script>
