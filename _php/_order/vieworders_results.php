<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_orders_read');

//---------------------------------------------------------------
//  Performs a search for orders based on the criteria 
//  entered in "vieworders_form.php" and displays results table
//---------------------------------------------------------------

$_SESSION['findOrders_orderNum_start'] 	= trim(sql_prep($_GET['orderNum_start']));
$_SESSION['findOrders_orderNum_end'] 		= trim(sql_prep($_GET['orderNum_end']));
$_SESSION['findOrders_orderNum_range'] 	= trim(sql_prep($_GET['orderNum_range']));
$_SESSION['findOrders_patron'] 				= trim(sql_prep($_GET['patron']));
$_SESSION['findOrders_department'] 			= trim(sql_prep($_GET['department']));
$_SESSION['findOrders_showIncomplete'] 	= trim(sql_prep($_GET['show_incomplete']));
$_SESSION['findOrders_showComplete'] 		= trim(sql_prep($_GET['show_complete']));
$_SESSION['findOrders_created_by']			= trim(sql_prep($_GET['created_by']));
$_SESSION['findOrders_created_start']		= trim(sql_prep($_GET['created_start']));
$_SESSION['findOrders_created_end']	 		= trim(sql_prep($_GET['created_end']));
$_SESSION['findOrders_updated_by']			= trim(sql_prep($_GET['updated_by']));

$pageNum = $_GET['pageNum'];
$orderBy = $_GET['orderBy'];
$order = $_GET['order'];


$sql = "SELECT username 
			FROM dimli.user 
			WHERE display_name = '{$_SESSION['findOrders_created_by']}' ";

$result = db_query($mysqli, $sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$createdBy = $row['username'];
	}
}


$sql = "SELECT username 
			FROM dimli.user 
			WHERE display_name = '{$_SESSION['findOrders_updated_by']}' ";

$result = db_query($mysqli, $sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$updatedBy = $row['username'];
	}
}


$created_start = ($_SESSION['findOrders_created_start'] != 'Created after') 
	? date('Y-m-d', strtotime($_SESSION['findOrders_created_start'])) 
	: '';

$created_end = ($_SESSION['findOrders_created_end'] != 'Created before') 
	? date('Y-m-d', strtotime($_SESSION['findOrders_created_end'])) 
	: '';


//---------------------------
//  Build the search query
//---------------------------

$sql = "SELECT SQL_CACHE * 
			FROM dimli.order 
			WHERE id != 0 ";

$sql.= (!empty($_SESSION['findOrders_orderNum_start'])
			&& $_SESSION['findOrders_orderNum_start'] != ''
			&& $_SESSION['findOrders_orderNum_range'] != 'yes')
	? " AND id = {$_SESSION['findOrders_orderNum_start']} " 
	: '';

$sql.= (!empty($_SESSION['findOrders_orderNum_start'])
			&& $_SESSION['findOrders_orderNum_start'] != 'Order Id'
			&& $_SESSION['findOrders_orderNum_range'] == 'yes') 
	? " AND id >= {$_SESSION['findOrders_orderNum_start']} " 
	: '';

$sql.= (!empty($_SESSION['findOrders_orderNum_end']) 
			&& $_SESSION['findOrders_orderNum_end'] != 'Through Order Id'
			&& $_SESSION['findOrders_orderNum_range'] == 'yes') 
	? " AND id <= {$_SESSION['findOrders_orderNum_end']} " 
	: '';

//--------------------------------------------------------------
//  Add "complete" status stipulation to query, if appropriate
//--------------------------------------------------------------

if ($_SESSION['findOrders_showIncomplete'] == 'yes' 
	&& $_SESSION['findOrders_showComplete'] == 'yes')
	// User choses to see both complete AND incomplete orders
{
	// Any "complete" status is acceptable, so leave query alone
}
elseif ($_SESSION['findOrders_showIncomplete'] == 'yes' 
	&& $_SESSION['findOrders_showComplete'] == 'no')
	// User choses to see ONLY incomplete orders
{
	$sql.= " AND complete = '0' ";
}
elseif ($_SESSION['findOrders_showIncomplete'] == 'no' 
	&& $_SESSION['findOrders_showComplete'] == 'yes')
	// User choses to see ONLY complete orders
{
	$sql.= " AND complete = '1' ";
}
elseif ($_SESSION['findOrders_showIncomplete'] == 'no' 
	&& $_SESSION['findOrders_showComplete'] == 'no')
{
	$sql.= " AND complete = '999' ";
}

$sql.= (!empty($_SESSION['findOrders_patron']))
	? " AND requestor REGEXP '{$_SESSION['findOrders_patron']}' " 
	: '';

$sql.= (!empty($_SESSION['findOrders_department'])
			&& $_SESSION['findOrders_department'] != '')
	? " AND department = '{$_SESSION['findOrders_department']}' " 
	: '';

$sql.= (!empty($createdBy))
	? " AND created_by = '{$createdBy}' " 
	: '';

$sql.= (!empty($created_start)
			&& $created_start != '1969-12-31')
	? " AND date_created >= '{$created_start} 00:00:01' " 
	: '';

$sql.= (!empty($created_end)
			&& $created_end != '1969-12-31')
	? " AND date_created <= '{$created_end} 23:59:59' "
	: '';

$sql.= (!empty($updatedBy))
	? " AND last_update_by = '{$updatedBy}' " : '';
				
$sql.= " ORDER BY ".$orderBy." ".$order.", id ASC ";
$sql.= " LIMIT ".(($pageNum - 1) * 15).", 15 ";


$_SESSION['orderSearchResult'] = db_query($mysqli, $sql);

//-------------------------------------------------------
//  Find number of total results that would be returned 
//  from the above query without the LIMIT parameter
//-------------------------------------------------------

$sql = substr($sql, 0, strpos($sql, 'LIMIT'));
$result = db_query($mysqli, $sql);
$result_count = $result->num_rows;

if ($_SESSION['orderSearchResult']->num_rows > 0): // fox ?>

<table>

	<?php if ($pageNum != 1): ?>

	<div id="findOrders_nav_prevPage" 
		class="pointer"
		onclick="findOrders_loadResults(
			<?php echo ($pageNum - 1 != 0) ? $pageNum - 1 : $pageNum; ?>, 
			'<?php echo $orderBy; ?>', 
			'<?php echo $order; ?>'
			);"
		>&#9650;</div>

	<?php endif; ?>

	<?php if ($_SESSION['orderSearchResult']->num_rows >= 15): ?>

	<div id="findOrders_nav_nextPage" 
		class="pointer"
		onclick="findOrders_loadResults(
			<?php echo ( (($pageNum + 1) * 15) < ($result_count + 15) ) 
				? $pageNum + 1
				: $pageNum; ?>, 
			'<?php echo $orderBy; ?>', 
			'<?php echo $order; ?>'
			);"
		>&#9660;</div>

	<?php endif; ?>

	<tr>

		<th class="findOrders_colHeader pointer" 
			data-type="id"
			data-order="<?php echo (!isset($order) || $order == 'DESC') 
					? 'ASC' 
					: 'DESC'; ?>"
			>Order</th>

		<th></th>

		<th class="findOrders_colHeader pointer" 
			data-type="date_needed"
			data-order="<?php echo (!isset($order) || $order == 'DESC') 
					? 'ASC' 
					: 'DESC'; ?>"
			>Due</th>

		<th></th>

		<th class="findOrders_colHeader pointer" 
			data-type="requestor"
			data-order="<?php echo (!isset($order) || $order == 'DESC') 
					? 'ASC' 
					: 'DESC'; ?>"
			>Patron</th>

		<th class="findOrders_colHeader pointer" 
			data-type="id"
			data-order="<?php echo (!isset($order) || $order == 'DESC') 
					? 'ASC' 
					: 'DESC'; ?>"
			>Images</th>

		<th>Progress</th>

	</tr>
	
	<?php while ($row = $_SESSION['orderSearchResult']->fetch_assoc()): // dog ?>
		
		<tr class="findOrders_resultRow pointer">
		
			<!--
					Order Link
			-->
		
			<td class="orderResults_orderNum_cell">
			
				<?php 
				echo create_four_digits($row['id']);
				?>
				
			</td>

			<!--
					Due Color Indicator
			-->

			<td>

				<?php
				$orderComplete = $row['complete'];
				$today = date('Y-m-d');
				$due = date('Y-m-d', strtotime($row['date_needed']));
				$diff = (strtotime($due) - strtotime($today)) / (60*60*24);
				
				if ($orderComplete == '1'):
				// Order is complete ?>

					<img src="_assets/_images/icon_complete.gif" 
						alt="" 
						title="Complete">
				<?php 
				elseif ($orderComplete == '0' && $diff < 0):
				// Order is incomplete and overdue ?>

				 	<img src="_assets/_images/lamp_red.gif" 
				 		alt=""
				 		title="Overdue">
				<?php 
				elseif ($orderComplete == '0' && $due == $today):
				// Order is incomplete and due today ?>

					<img src="_assets/_images/warning.gif" 
						alt=""
						title="Due today">
				<?php 
				elseif ($orderComplete == '0' && $diff > 0 && $diff <= 7):
				// Order is incomplete and due within 1 week ?>

					<img src="_assets/_images/warning.gif" 
						alt="" 
						title="Due in <?php echo round($diff); ?> days">
				<?php 
				elseif ($orderComplete == '0' && $diff >=8 && $diff <= 14):
				// Order is incomplete and due within 2 weeks ?>

					<img src="_assets/_images/lamp_yellow.gif" 
						alt="" 
						title="Due in <?php echo round($diff); ?> days">
				<?php 
				elseif ($orderComplete == '0' && $diff >= 15):
				// Order is incomplete and due in greater than 2 weeks ?>

					<img src="_assets/_images/lamp_green.gif" 
						alt="" 
						title="Due in <?php echo round($diff); ?> days">
				<?php 
				endif; ?>

			</td>

			<!--
					Due
			-->

			<td style="white-space: nowrap;">

				<?php 
				$date = (date('Y', strtotime($row['date_needed'])) == date('Y')) 
					? date('M d', strtotime($row['date_needed'])) 
					: date('M d,\<\b\r \/\>Y', strtotime($row['date_needed']));

				echo $date; ?>

			</td>

			<!-- 
					Assigned cataloger
			 -->

			<td style="width: 17px;">

				<?php
				$sql = "SELECT assigned_to 
							FROM dimli.order 
							WHERE id = '{$row['id']}' ";

				$result = db_query($mysqli, $sql);

				while ($assigned = $result->fetch_assoc()):
					$assigned_to = $assigned['assigned_to'];
				endwhile;

				if (!empty($assigned_to) && 
						isset($assigned_to) && 
						$assigned_to != ''):

					$sql = "SELECT first_name, 
									last_name 
								FROM dimli.user 
								WHERE id = {$assigned_to} ";

					$result = db_query($mysqli, $sql);

					while ($user = $result->fetch_assoc()):
						$init1 = substr($user['first_name'], 0, 1);
						$init2 = substr($user['last_name'], 0, 1);
					endwhile;

					echo $init1.$init2;

				endif; ?>

			</td>

			<!--
					Patron
			-->

			<td style="width: 150px; white-space: nowrap; overflow: hidden;">

				<?php 
				echo $row['requestor']; ?>

			</td>

			<!--
					Image Range
			-->
			
			<?php
			$sql = "SELECT id
							FROM dimli.image
							WHERE order_id = '{$row['id']}' ";

			$result = db_query($mysqli, $sql);

			if ($result->num_rows > 0):

				while ($image = $result->fetch_assoc()):
					$imagesArray[] = $image['id'];
				endwhile;
				$firstImageId = create_six_digits(min($imagesArray));
				$lastImageId = create_six_digits(max($imagesArray));
				unset($imagesArray); ?>

				<td style="white-space: nowrap;">
				
					<?php 
					echo (!empty($firstImageId))
						? $firstImageId.' - ' 
						: '';
					echo (!empty($lastImageId))
						? $lastImageId 
						: ''; ?>
				
				</td>

			<?php endif; ?>

			<!--
					Progress bars
			-->

			<td style="width: 205px; font-size: 0;">

				<div>

					<!-- Digitized -->

					<div class="orderProgressBar_section<?php echo ($row['order_digitized'] == '1') ? ' orderProgressBar_sectionComplete' : ''; ?>" 
						style="border-radius: 0px 0 0 0px;" 
						title="<?php echo ($row['order_digitized'] == '1')
							? 'Order digitized by ' . $row['order_digitized_by']
							: 'Order not yet digitized'; ?>"></div>

					<!-- Edited -->

					<div class="orderProgressBar_section<?php echo ($row['images_edited'] == '1') ? ' orderProgressBar_sectionComplete' : ''; ?>" 
						title="<?php echo ($row['images_edited'] == '1')
							? 'Images edited by ' . $row['images_edited_by']
							: 'Images not yet edited'; ?>"></div>

					<!-- Exported -->

					<div class="orderProgressBar_section<?php echo ($row['images_exported'] == '1') ? ' orderProgressBar_sectionComplete' : ''; ?>" title="<?php echo ($row['images_exported'] == '1')
						? 'Images exported by ' . $row['images_exported_by']
						: 'Images not yet exported'; ?>"></div>

					<!-- Delivered -->

					<div class="orderProgressBar_section<?php echo ($row['images_delivered'] == '1') ? ' orderProgressBar_sectionComplete' : ''; ?>" title="<?php echo ($row['images_delivered'] == '1')
						? 'Images delivered to patron by ' . $row['images_delivered_by']
						: 'Images not yet delivered to patron'; ?>"></div>

					<!-- Cataloged -->

					<div class="orderProgressBar_section<?php echo ($row['images_catalogued'] == '1') ? ' orderProgressBar_sectionComplete' : ''; ?>" title="<?php echo ($row['images_catalogued'] == '1')
						? 'Images catalogued by ' . $row['images_catalogued_by']
						: 'Images not yet catalogued'; ?>"></div>

					<!-- Approved -->

					<div class="orderProgressBar_section<?php echo ($row['cataloguing_approved'] == '1') ? ' orderProgressBar_sectionComplete' : ''; ?>" style="border-radius: 0 0px 0px 0; border-right: none;" title="<?php echo ($row['cataloguing_approved'] == '1')
						? 'Cataloguing approved by ' . $row['cataloguing_approved_by']
						: 'Cataloguing not yet approved'; ?>"></div>

				</div>

				<?php
				//-------------------------------------------
				//  Count images with completed cataloguing
				//-------------------------------------------

				$sql = "SELECT * 
								FROM dimli.image 
								WHERE order_id = '{$row['id']}' 
									AND catalogued = '1' ";

				$result = db_query($mysqli, $sql);

				$numImagesComplete = $result->num_rows; ?>

				<div>

					<div class="cataProgressBar_wrapper" 
						title="<?php echo $numImagesComplete.' of '.$row['image_count'].' catalogued'; ?>">

						<div class="cataProgressBar_text">

							<?php
							echo $numImagesComplete.' / '.$row['image_count']; ?>

						</div>

						<div class="cataProgressBar_fill" 
							style="width: <?php echo ($numImagesComplete / $row['image_count']) * 203; ?>px;">

						</div>

					</div>

				</div>

			</td>
			
		</tr>
		
	<?php endwhile; // dog ?>

</table>

<?php else: // fox ?>

<p class="center_text" 
	style="margin-top: 30px; font-size: 1.5em;"
	>no results</p>

<?php endif; // fox ?>

<script>

	$('tr.findOrders_resultRow').hover(
		function()
		{
			$(this).addClass('row_highlight');
		}, 
		function()
		{
			$(this).removeClass('row_highlight');
		})
	.click(
		function()
		{
			var orderNum = $(this).find('td:first-child').text();
			orderNum = $.trim(orderNum);
			open_order(orderNum);
		});

	$('div#browse_orders_module h1 div.floatRight').remove();

	$('div#browse_orders_module h1')
		.append('<div class="floatRight">Page '+<?php echo $pageNum; ?>+' of '+<?php echo round($result_count / 15) + 1; ?>+' ('+<?php echo $result_count; ?>+' total results)</div>');

	
	//----------------------------------
	//  Click on column header to sort
	//----------------------------------

	$('.findOrders_colHeader').click(
		function()
		{
			var type = $(this).attr('data-type');
			var order = $(this).attr('data-order');

			findOrders_loadResults('1', type, order);
		});

</script>