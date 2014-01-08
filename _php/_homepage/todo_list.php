<?php 
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');

confirm_logged_in(); 
?>

<!-- 
	TO DO LIST FOR CATALOGERS
 -->

<div id="yourOrders">

	<h3>To Do</h3>

	<div id="todo_list" class="defaultCursor">

	<?php $sql = "SELECT * 
						FROM $DB_NAME.order 
						WHERE assigned_to = '{$_SESSION['user_id']}' 
						AND (images_catalogued = false 
							OR images_catalogued IS NULL)
						ORDER BY date_needed, id ASC
						LIMIT 5 ";

	$orders = db_query($mysqli, $sql);

	if ($orders->num_rows <= 0): ?>

		<div style="max-width: 180px; padding: 15px; font-size: 0.85em; text-align: center; line-height: 1.4em; font-weight: 400;">LUCKY! - you have no assigned work to complete</div>

	<?php endif;

		while ($row = $orders->fetch_assoc()):

			// Fetch export status of this order
			$sql = "SELECT images_exported 
						FROM $DB_NAME.order 
						WHERE id = {$row['id']} ";

			$imgs_ava_res = db_query($mysqli, $sql);

			while ($row_exported = $imgs_ava_res->fetch_assoc()):
				$imgs_ava = $row_exported['images_exported'];
			endwhile; 

			$imgs_ava_res->free();

			// Fetch all image ids associated with this order
			$sql = "SELECT id 
						FROM $DB_NAME.image 
						WHERE order_id = {$row['id']} 
						LIMIT 3 ";

			$result = db_query($mysqli, $sql);

			$images = array();

			while ($img_row = $result->fetch_assoc()):

				$images[] = str_pad($img_row['id'], 6, '0', STR_PAD_LEFT);

			endwhile; ?>

			<div class="row">

				<div class="inner_row thumbnail_previews">

					<span class="order_id" 
						data-order="<?php echo $row['id']; ?>">#<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></span>

					<?php if ($imgs_ava == '1'): ?>

						<?php foreach ($images as $image): ?>

							<img src="http://$DB_NAME.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/thumb/<?php echo $image; ?>.jpg&amp;h=28&amp;w=35&amp;q=80">

						<?php endforeach; ?>

					<?php else: ?>

						<span class="grey" 
							style="margin-left: 10px; font-size: 0.9em;"
							>Images unavailable</span>

					<?php endif; ?>

				</div>

				<div class="inner_row grey" 
					style="font-size: 0.80em;">

					<?php echo $row['image_count'].' image'; 

					echo ($row['image_count'] > 1) 
						? 's' 
						: '';

					echo ', due '.date('l, M j', strtotime($row['date_needed'])); ?>

				</div>

			</div>

		<?php endwhile; ?>

	</div>

</div>

<script>

	$('div#todo_list div.row')
		.click(
			function()
			{
				var orderNum = $(this).find('span.order_id').attr('data-order');
				open_order($.trim(orderNum));
			});

</script>
