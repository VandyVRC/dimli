<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_orders_read');


//-----------------
//	Log this visit
//-----------------

$_SESSION['order'] = $_GET['order'];

// Log this visit
$UnixTime = time(TRUE);
$sql = "INSERT INTO dimli.Activity 
			SET UserID = '{$_SESSION['user_id']}',
				RecordType = 'Order',
				RecordNumber = '{$_SESSION['order']}',
				ActivityType = 'viewed',
				UnixTime = '{$UnixTime}' ";
$result = db_query($mysqli, $sql);


//-----------------------------
//	Retrieve Order Information
//-----------------------------

$sql = "SELECT * 
			FROM dimli.order 
			WHERE id = '{$_SESSION['order']}' ";

$result = db_query($mysqli, $sql);

while ($row = $result->fetch_assoc()) {

	$client = 		$row['requestor'];
	$department = 	$row['department'];
	$email = 		$row['email'];
	$dateCreated = $row['date_created'];
	$createdBy = 	$row['created_by'];

		$sql = "SELECT * 
					FROM dimli.user 
					WHERE username = '{$createdBy}' ";

		$result = db_query($mysqli, $sql);

		while ($creatorRow = $result->fetch_assoc()) {
			$orderAccessionerDisplayName = $creatorRow['first_name'].' '.$creatorRow['last_name'];
		}

	$dateNeeded = 		$row['date_needed'];
	$imageCount = 		$row['image_count'];
	$cataloger_id = 	$row['assigned_to'];
	$orderComplete = 	$row['complete'];
	$lastUpdate = 		$row['last_update'];
	$lastUpdateBy = 	$row['last_update_by'];

		$sql = "SELECT * 
					FROM dimli.user 
					WHERE username = '{$lastUpdateBy}' ";

		$result = db_query($mysqli, $sql);

		while ($updaterRow = $result->fetch_assoc()) {
			$orderUpdaterDisplayName = $updaterRow['first_name'].' '.$updaterRow['last_name'];
		}

	$orderDigitized = $row['order_digitized'];
		$orderDigitizedBy = $row['order_digitized_by'];
		$orderDigitizedOn = $row['order_digitized_on'];

	$imagesEdited = $row['images_edited'];
		$imagesEditedBy = $row['images_edited_by'];
		$imagesEditedOn = $row['images_edited_on'];

	$imagesExported = $row['images_exported'];
		$imagesExportedBy = $row['images_exported_by'];
		$imagesExportedOn = $row['images_exported_on'];

	$imagesDelivered = $row['images_delivered'];
		$imagesDeliveredBy = $row['images_delivered_by'];
		$imagesDeliveredOn = $row['images_delivered_on'];

	$imagesCatalogued = $row['images_catalogued'];
		$imagesCataloguedBy = $row['images_catalogued_by'];
		$imagesCataloguedOn = $row['images_catalogued_on'];

	$cataloguingApproved = $row['cataloguing_approved'];
		$cataloguingApprovedBy = $row['cataloguing_approved_by'];
		$cataloguingApprovedOn = $row['cataloguing_approved_on'];
	
}


//---------------------
//  Fetch image info
//---------------------

$sql = "SELECT * 
			FROM dimli.image 
			WHERE order_id = '{$_SESSION['order']}' ";

$result_orderHQ_images = db_query($mysqli, $sql);
	

//---------------------------------------------------------
//  Fetch info about recent status updates to this order
//---------------------------------------------------------

$sql = "SELECT * 
			FROM dimli.order 
			WHERE id = '{$_SESSION['order']}' ";

$statusResult = db_query($mysqli, $sql);

while ($row = $statusResult->fetch_assoc()) {

	$orderComplete = 	$row['complete'];
	$lastUpdate = 		$row['last_update'];
	$lastUpdateBy = 	$row['last_update_by'];

	$orderDigitized = $row['order_digitized'];
		$orderDigitizedBy = $row['order_digitized_by'];
		$orderDigitizedOn = $row['order_digitized_on'];

	$imagesEdited = $row['images_edited'];
		$imagesEditedBy = $row['images_edited_by'];
		$imagesEditedOn = $row['images_edited_on'];

	$imagesExported = $row['images_exported'];
		$imagesExportedBy = $row['images_exported_by'];
		$imagesExportedOn = $row['images_exported_on'];

	$imagesDelivered = $row['images_delivered'];
		$imagesDeliveredBy = $row['images_delivered_by'];
		$imagesDeliveredOn = $row['images_delivered_on'];

	$imagesCatalogued = $row['images_catalogued'];
		$imagesCataloguedBy = $row['images_catalogued_by'];
		$imagesCataloguedOn = $row['images_catalogued_on'];

	$cataloguingApproved = $row['cataloguing_approved'];
		$cataloguingApprovedBy = $row['cataloguing_approved_by'];
		$cataloguingApprovedOn = $row['cataloguing_approved_on'];

}


//------------------------------------------------------
//  Determine if every aspect of the order is complete
//------------------------------------------------------

if ($imagesEdited == 1 && $imagesExported == 1 && $imagesDelivered == 1 && $imagesCatalogued == 1 && $cataloguingApproved == 1) {

	$orderComplete = '1';

} else {

	$orderComplete = '0';

}
	
	
//------------------------------------------------------
//  Update the "complete" status of the current order
//------------------------------------------------------

$sql = "UPDATE dimli.order 
			SET complete = '{$orderComplete}' 
			WHERE id = '{$_SESSION['order']}' ";

$result = db_query($mysqli, $sql);

#############################################################
#####################  BEGIN CLIENT-SIDE  ###################
#############################################################
?>

<div class="order_nav_bar defaultCursor"></div>

<?php if ($_SESSION['priv_catalog'] == '1'): ?>

<div id="order_assigned_cataloger">

	<select>

		<option data-id="0">- Unassigned -</option>

		<?php $sql = "SELECT * 
							FROM dimli.user 
							WHERE pref_user_type = 'cataloger' 
							ORDER BY id";

		$result = db_query($mysqli, $sql);

		while ($row = $result->fetch_assoc()):
			$catalogers[] = array('id'=>$row['id'], 'name'=>$row['display_name']);
		endwhile;

	foreach ($catalogers as $cataloger): ?>

		<option data-id="<?php echo $cataloger['id']; ?>" 
			<?php echo ($cataloger['id']==$cataloger_id)?'selected':''; ?>
			><?php echo $cataloger['name']; ?></option>

	<?php endforeach; ?>

	</select>

</div>

<?php endif; ?>

<p style="font-size: 1.2em; color: #89899c; text-align: center;">

	<?php // Echo main headline at the top of the order window
	echo $imageCount;
	echo ' images for ';
	echo $client;
	echo ' (due on ';
	echo date('M j, Y', strtotime($dateNeeded));
	echo ')'; ?>

</p>

<div id="orderView_wrapper">

	<div id="orderView_imageList">
	
		<?php $i = 0; ?>
		<?php while ($row = $result_orderHQ_images->fetch_assoc()): ?>
	
		<div class="orderView_imageRow defaultCursor" 
			style="position: relative;">
		
			<!-- Image ID -->
			<div class="imageList_imageNum purple" 
				style="display: inline-block; width: 70px;">

				<?php
				$imageId = create_six_digits($row['id']);
				echo $imageId; ?>

			</div>
			
			<!-- Thumbnail -->
			<div class="orderView_imageList_thumb">

				<?php 
				// Define filepath for thumbnail
				$img_file = IMAGE_DIR.'thumb/'.create_six_digits($row['id']).'.jpg';
				
				if ($i == 0) { 
				// Perform only for first image in the order
					$thumbs_available = checkRemoteFile($img_file);
				}
				
				if ($thumbs_available) { 
				// If imagepath of first image was found ?>

					<img style="vertical-align: top; height: 100%;"
						src="<?php echo $img_file; ?>">

				<?php } else { ?>

					<img style="vertical-align: top; height: 100%;" 
						src="_assets/_images/_missing.jpg">

				<?php } ?>

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
				style="display: inline-block; width: 70px; line-height: 1.3em; padding-right: 10px;">
			
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
				<?php echo ($_SESSION['priv_images_flag4Export'] == '1') ? ' pointer active' : ''; ?>
				<?php echo ($row['flagged_for_export'] == 1) ? ' flagged' : ''; ?>"
				style="background-image: url(_assets/_images/flags_green.png);"
				title="<?php echo ($row['flagged_for_export'] != 1) ? 'Flag for export' : 'Clear export flag'; ?>"></div>

			<?php if ($_SESSION['priv_images_delete'] == '1'): ?>
			
				<!-- Delete image: button -->
				<div class="deleteRecord_button pointer faded"
					style="background-image: url(_assets/_images/delete_v2.png);"
					title="Delete image <?php echo $imageId; ?>"
					onclick="deleteImageRecord('<?php echo $imageId; ?>')"></div>

			<?php endif; ?>
			
		<!-- end orderView_imageRow -->
		</div>
		
		<?php $i++; ?>
		<?php endwhile; ?>
		
	<!-- end orderView_imageList -->
	</div>
	
<!-- end orderView_wrapper -->
</div>

<div id="progress_wrapper">

	<div id="progress_dig"
		class="progress_button pointer<?php echo ($_SESSION['priv_digitize']=='1')?' active':''; echo($orderDigitized == '1')?' complete':'';?>"
		>digitized</div><!--

	--><div id="progress_edi"
		class="progress_button pointer<?php echo ($_SESSION['priv_edit']=='1')?' active':''; echo($imagesEdited == '1')?' complete':'';?>"
		>edited</div><!--

	--><div id="progress_exp"
		class="progress_button pointer<?php echo ($_SESSION['priv_exportImages']=='1')?' active':''; echo($imagesExported == '1')?' complete':'';?>"
		>exported</div><!--

	--><div id="progress_del"
		class="progress_button pointer<?php echo ($_SESSION['priv_deliver']=='1')?' active':''; echo($imagesDelivered == '1')?' complete':'';?>"
		>delivered</div><!--

	--><div id="progress_cat"
		class="progress_button pointer<?php echo ($_SESSION['priv_catalog']=='1')?' active':''; echo($imagesCatalogued == '1')?' complete':'';?>"
		>cataloged</div><!--

	--><div id="progress_app"
		class="progress_button pointer<?php echo ($_SESSION['priv_approve']=='1')?' active':''; echo($cataloguingApproved == '1')?' complete':'';?>"
		>approved</div>

</div>

<script>

	var order_num = <?php echo json_encode(trim($_SESSION['order'])); ?>;
	var order_imageCount = <?php echo json_encode($imageCount); ?>;

	order_navigation();

	closeModule_button($('div#order_module'));

	// Prepare hover event for image rows
	// and click event to open work and image records

	$('div.orderView_imageRow').hover(
		function() 
		{
			$(this).addClass('row_highlight');
		},
		function() 
		{
			$(this).removeClass('row_highlight');
		});

	
	// SELECT IMAGE RECORD ROW

	$('div.orderView_imageRow')
		.not('.flagRecord_button,.deleteRecord_button,.orderView_imageList_thumb,.orderView_imageList_thumb img')
		.click(
			function(event)
			{
				event.stopPropagation();
				if ($(event.target).hasClass('flagRecord_button')
					|| $(event.target).hasClass('deleteRecord_button'))
				{

				}
				else
				{
					var imageNum = $(this).find('div.imageList_imageNum').text();
					view_image_record(imageNum);
					view_work_record(imageNum);
				}
			});


	$('div.orderView_imageList_thumb')
		.hover(
			function() 
			{
				$(this).addClass('glow');
			},
			function() 
			{
				$(this).removeClass('glow');
			})
		.click(
			function() 
			{
				event.stopPropagation();
				var image = $(this).parents('.orderView_imageRow').find('.imageList_imageNum').text();
				image_viewer(image);
			});


	// UPDATE EXPORT FLAG STATUS

	$('div.flagRecord_button.active').click(
		function()
		{
			var image_num = $.trim($(this)
								.parents('div.orderView_imageRow')
								.find('div.imageList_imageNum')
								.text());

			var status = $.trim($(this)
								.parents('div.orderView_imageRow')
								.find('div.export_flag_status')
								.text());

			updateExportFlag(image_num, status);
		});


	// UPDATE ORDER PROGRESS

	$('div.progress_button.active').bind('click.progressToggle',
		function(event)
		{
			order_updateProgress(event, order_num);
		});


	// UPDATE ASSIGNED CATALOGER

	$('div#order_assigned_cataloger select')
		.change(
			function()
			{
				var order = '<?php echo $_SESSION['order']; ?>';
				var uid = $(this).find(':selected').attr('data-id');
				var username = $(this).find(':selected').val();
				order_updateCataloger(order, uid, username);
			});

</script>