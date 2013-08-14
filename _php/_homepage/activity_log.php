<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
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
			FROM dimli.Activity 
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

<?php if ($activity_r->num_rows <= 0):
// Current user has NO ACTIVITY logged ?>

	<br>
	<p style="font-size: 0.9em; opacity: 0.6; margin-bottom: 20px;">Welcome to Dimli, <?php echo $_SESSION['first_name']; ?>.<br><br>In the future, your recent activity will be displayed here along the left-hand side of your profile page.</p>

<?php else:
// Current user DOES HAVE some activity logged ?>

	<?php $i = 0; ?>
	<?php while ($row = $activity_r->fetch_assoc()):
	// For each logged action ?>

		<?php if ($i >= 16) break; 
		// Show no more than 16 rows ?>

		<?php $pref_image = ''; ?>


		<?php if ($row['RecordType'] == 'Order'):
		// Action was performed on an Order ?>

			<?php $sql = "SELECT * FROM dimli.order 
								WHERE id = {$row['RecordNumber']} ";
			$orderInfo = db_query($mysqli, $sql); ?>

			<?php if ($orderInfo->num_rows <= 0) continue; ?>

			<?php while ($order = $orderInfo->fetch_assoc()):

				$patron = (strlen($order['requestor']) > 25)
					? substr($order['requestor'], 0, 25) . '..'
					: $order['requestor'];

				$imgCount = $order['image_count'];

			endwhile; ?>

		<?php endif; ?>


		<?php if ($row['RecordType'] == 'Work'):
		// Action was performed on an Work ?>

			<?php $sql = "SELECT preferred_image 
								FROM dimli.work 
								WHERE id = {$row['RecordNumber']} ";
			$workInfo = db_query($mysqli, $sql); ?>

			<?php while ($work = $workInfo->fetch_assoc()):

				$pref_image = $work['preferred_image'];

			endwhile; ?>

			<?php $img = $pref_image; ?>

		<?php endif; ?>


		<?php if ($row['RecordType'] == 'Image'): ?>

			<?php $img = str_pad($row['RecordNumber'], 6, '0', STR_PAD_LEFT); ?>

		<?php endif; ?>


		<?php $str = '<span class="">'; ?>
		<?php $str.= ($row['UserID']==$_SESSION['user_id'])
			? ' You '
			: ' -- '; ?>
		<?php $str.= $row['ActivityType'].' '; ?>
		<?php $str.= $row['RecordType'].' '; ?>
		<?php $recNo = ($row['RecordType']=="Order") 
			? str_pad($row['RecordNumber'], 4, '0', STR_PAD_LEFT).' ' 
			: str_pad($row['RecordNumber'], 6, '0', STR_PAD_LEFT).' '; ?>
		<?php $str.= $recNo; ?>
		<?php $str.= '</span>'; ?>
		<?php $str.= '<br><span class="" style="font-size: 0.75em; color: #999;">'; ?>

		<?php $str.= date('Y-m-d H:i:s', $row['UnixTime']); // REVISIT 
		// Should be changed to a human-readbale timestamp ?>

		<?php $str.= '</span>'; ?>

		<div class="row defaultCursor" 
			data-type="<?php echo $row['RecordType']; ?>"
			data-pref-image="<?php echo ($pref_image!='') 
											? $pref_image 
											: 'none'; ?>"
			data-id="<?php echo $recNo; ?>"><!--

			--><?php echo $str; ?>

			<?php if (in_array($row['RecordType'], array('Work', 'Image')) && checkRemoteFile("http://dimli.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/thumb/".$img.".jpg")): ?>

				<img src="http://dimli.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/thumb/<?php echo $img; ?>.jpg&amp;h=30&amp;w=40&amp;q=90"
					style="float: right; margin-top: -15px;">

			<?php elseif ($row['RecordType'] == 'Order'): ?>

				<div style="float: right; margin-top: -15px;">

					<span style="display: inline; vertical-align: middle; font-size: 15px;"><?php echo $imgCount; ?></span>
					<img style="height: 25px; vertical-align: middle; margin-left: 3px;" src="_assets/_images/photos.png">

				</div>

			<?php endif; ?>

		</div>

	<?php $i ++; ?>
	<?php endwhile; ?>

<?php endif; ?>

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