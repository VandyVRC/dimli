<?php 
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');

confirm_logged_in(); ?>

<div id="yourOrders">

	<h3>Your Orders</h3>

	<?php $current_user = $_SESSION['first_name'].' '.$_SESSION['last_name'];

	$sql = "SELECT * 
				FROM $DB_NAME.order 
				WHERE requestor = '{$current_user}' ";

	$result = db_query($mysqli, $sql);
	$total_orders = $result->num_rows;

	$sql = "SELECT * 
				FROM $DB_NAME.order 
				WHERE requestor = '{$current_user}' 
				ORDER BY date_created DESC ";

	$sql.= (isset($_POST['limit']) && $_POST['limit'] == 'none') 
				? ""
				: " LIMIT 5";

	$orders = db_query($mysqli, $sql); ?>

	<div id="orderDelivery_list" class="defaultCursor">

	<?php if ($orders->num_rows <= 0): 
		// Current user has submitted no orders ?>

		<div class="row message">

			<span>You have not yet placed any orders</span>

		</div>

	<?php endif;

	while ($row = $orders->fetch_assoc()):

		//  Determine whether this order's images have
		//  been exported to permanent storage

		$sql = "SELECT images_exported 
					FROM $DB_NAME.order 
					WHERE id = {$row['id']} ";

		$result = db_query($mysqli, $sql);

		while ($row2 = $result->fetch_assoc()):
			$imgs_ava = $row2['images_exported'];
		endwhile;

		$result->free();


		//  Select three images from this order to display
		//  as thumbnail previews in the list of orders

		$sql = "SELECT id 
					FROM $DB_NAME.image 
					WHERE order_id = {$row['id']} 
					LIMIT 3 ";

		$result = db_query($mysqli, $sql);

		$images = array(); // Will store the ids of the three image previews

		while ($row3 = $result->fetch_assoc()):
			// Populate array with preview ids
			$images[] = str_pad($row3['id'], 6, '0', STR_PAD_LEFT); 
		endwhile; ?>

		<div class="row">

			<div class="inline floatLeft" 
				style="width: 270px;">

				<?php if ($imgs_ava == '1'):
					// Images have been exported for this order ?>

				<div class="inner_row thumbnail_previews">

					<?php foreach ($images as $image): ?>

						<img src="http://$DB_NAME.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/thumb/<?php echo $image; ?>.jpg&amp;h=28&amp;w=35&amp;q=80">

					<?php endforeach; ?>

					<span style="color: #999; font-size: 0.8em;">

						<?php 
						echo $row['image_count'];
						echo ' image';
						echo ($row['image_count'] > 1)
							? 's'
							: ''; ?>

					</span>

				</div>

				<?php else: 
					// Images have not been exported for this order, and so are not available to be displayed as thumbnails

				endif; ?>

				<div class="inner_row source_title">

					<?php 
					//  Fetch the name of the source of this order
					//  to display along with this order record

					$sql = "SELECT image.id, 
											image.order_id, 
											source.related_images, 
											source.source_name_text, 
											source.source_name_type 
										FROM $DB_NAME.image INNER JOIN $DB_NAME.source 
										ON image.id = source.related_images 
										WHERE image.order_id = {$row['id']} 
										ORDER BY image.id 
										LIMIT 1 ";

					$result = db_query($mysqli, $sql);

					while ($source = $result->fetch_assoc()):
						echo $source['source_name_text'].' ('.$source['source_name_type'].')';
					endwhile; ?>

				</div>

				<div class="inner_row grey" 
					style="font-size: 0.80em; margin: 10px 0; max-width: 250px;">

					<?php 
					echo 'Order '.str_pad($row['id'], 4, '0', STR_PAD_LEFT).' placed on '.date('D, F j', strtotime($row['date_created'])); ?>

				</div>

			</div>

			<?php if ($imgs_ava == '1'): ?>

				<div class="download_options inline floatRight">

					<?php $order = str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>

					<a href="_php/_download/download_archive.php?order=<?php echo$order;?>&amp;size=medium"
						class="download_medium"
						title="Download ZIP archive of medium-sized JPGs"
						data-order="<?php echo$order;?>">

						<img src="_assets/_images/zip.png">
						<span class="label">Medium ZIP</span><br>
					</a>

					<?php 
					if (file_exists(MAIN_DIR.'/_ppts/'.str_pad($row['id'], 4, '0', STR_PAD_LEFT).'.pptx')): ?>

					<a href="_php/_download/download_ppt.php?order=<?php echo$order;?>"
						class="download_ppt"
						title="Download PowerPoint file"
						data-order="<?php echo$order;?>">

						<img src="_assets/_images/ppt.png">
						<span class="label">PPT</span>
					</a>

					<?php endif; ?>

					<a href="_php/_download/download_archive.php?order=<?php echo$order;?>&amp;size=full"
						class="download_full" 
						title="Download ZIP archive of full-sized JPGs"
						data-order="<?php echo$order;?>">

						<img src="_assets/_images/zip.png">
						<span class="label">Full ZIP</span>
					</a>

				</div>

			<?php else: ?>

				<div class="inProgress">In progress</div>

			<?php endif; ?>

			<p class="clear"></p>

		</div>

<?php endwhile; ?>

		<?php if ($total_orders > $orders->num_rows): ?>

		<div class="row showMore">

			<span class="pointer">Display all past orders</span>

		</div>

		<?php endif; ?>

	</div>

	<script id="yourOrders_script">

		$('div.showMore span').click(
			function()
			{
				$(this).replaceWith('<div class="loading_gif">');

				$.ajax({
					type: 'POST',
					data: 'limit=none',
					url: '_php/_homepage/your_orders.php',
					success: function(response)
					{
						$('div#yourOrders').replaceWith(response);
					},
					error: function()
					{
						console.log("AJAX error: your_orders.php");
					}
				});
			});

	</script>

</div>
