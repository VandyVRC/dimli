<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();

$sql = "SELECT * 
			FROM $DB_NAME.image 
			WHERE id = '{$_GET['image']}' ";

$refresh_r = db_query($mysqli, $sql);

while ($row = $refresh_r->fetch_assoc()) { ?>

	<!-- Image ID -->
	<div class="imageList_imageNum purple" 
		style="display: inline-block; width: 70px;">

		<?php 
		$imageId = create_six_digits($row['id']);
		$legId = $row['legacy_id'];
		echo $legId; 
		$fileFormat =$row['file_format'];	

			//Truncate Legacy Id for style intrusion if needed
			$truncLeg = (strlen($legId) > 6) 
			? substr($legId, 0, 6) . '...' 
			: $legId;?>

			<!-- Hidden Image ID -->
	<div class="imageList_imageNum_hidden" hidden><?php echo $imageId;?></div>
	</div>

	<!-- Thumbnail -->
	<div class="orderView_imageList_thumb">

		<?php 
		$img_file = $image_dir.$legId.'.jpg';
		
		if (checkRemoteFile($img_file)) {
			$img_file = $img_file;
		} else {
			$img_file = '_assets/_images/_missing.jpg';
		}

		// $img_file = (file_exists($img_file))
		// 	? substr($img_file, 3) 
		// 	: '_assets/_images/_missing.jpg'; ?>
		
		<img style="vertical-align: top; height: 100%;"
			src="<?php echo $img_file; ?>">

	</div>

	<!-- Title and agent -->
	<div class="hoverCursor" 
		style="display: inline-block; width: 335px; margin-left: 10px;">

		<div style="line-height: 16px;">

			<?php require('query_title.php'); ?>

		</div>
		
		<div style="line-height: 16px;">

			<span style="font-size: 0.8em; color: #919191;">

				<?php require('query_agent.php'); ?>

			</span>

		</div>

	</div>
							
	<!-- Page number -->
	<div class="hoverCursor"
		title="Page"
		style="display: inline-block; width: 70px;">

		<?php
		echo (!empty($row['page']))
			? $row['page']
			: '--'; ?>
		
	</div>

	<!-- Figure number -->
	<div class="hoverCursor"
		title="Figure"
		style="display: inline-block; line-height: 15px;">

		<?php
		echo (!empty($row['fig']))
			? $row['fig']
			: '--'; ?>
		
	</div>

	<!-- Export flag: status (hidden) -->
	<div class="export_flag_status hidden">
		<?php echo $row['flagged_for_export']; ?>

	</div>

	<!-- Export flag: icon -->
	<div class="flagRecord_button faded
		<?php echo ($_SESSION['priv_images_flag4Export'] == '1')?' pointer active':''; echo ($row['flagged_for_export'] == 1)?' flagged':''; ?>"
		style="background-image: url(_assets/_images/flags_green.png);"
		title="<?php echo ($row['flagged_for_export'] != 1) ? 'Flag for export' : 'Clear export flag'; ?>"></div>

	<?php if ($_SESSION['priv_images_delete'] == '1'): ?>

		<!-- Delete image: button -->
		<div class="deleteRecord_button pointer faded"
			style="background-image: url(_assets/_images/delete_v2.png);"
			title="Delete image <?php echo $legId; ?>"
			onclick="deleteImageRecord('<?php echo $imageId; ?>')"></div>

	<?php endif; ?>

<?php } ?>

