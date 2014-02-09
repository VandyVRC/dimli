<?php
$results = new ArrayIterator($results_arr);
$rpp = 60; // "Results per page"

if (($page*$rpp)-$rpp <= count($results))
{

	$i = 0;
	foreach (new LimitIterator($results, (($page*$rpp)-$rpp), $rpp) as $resid=>$arr)
	{
		if ($i == $rpp) break;

		// Trim 'work' or 'image' from beginning of id string
		$id = substr($resid, -6);

		// Define array of search types that yielded results for this record
		// by combining search arrays for all terms together
		$searches_arr = array();
		foreach ($arr['search'] as $term_arr) {
			$searches_arr = array_merge($searches_arr, $term_arr);
		}
		$searches_arr = array_unique($searches_arr); //print_r($searches_arr);

		// Determine the preferred thumbnail image for this record
		// And assign a parent Work, if available
		if ($arr['type']=='work')
		{
			$short_id = ltrim($id, '0');

			$sql = "SELECT preferred_image 
						FROM dimli.work 
						WHERE id = {$short_id} ";

			$res = db_query($mysqli, $sql);

			while ($work = $res->fetch_assoc())
			{ 
				$img_id = create_six_digits($work['preferred_image']);
			}
			$parent = 'none';
		}
		elseif ($arr['type']=='image')
		{
			$img_id = create_six_digits($id);

			// Find this Image's parent Work
			$sql = "SELECT related_works 
							FROM dimli.image 
							WHERE id = {$id} ";

			$result = db_query($mysqli, $sql);

			while ($row = $result->fetch_assoc()) {
				
				$parent = (trim($row['related_works'] != '')) 
							? $row['related_works'] 
							: 'none';
			}
		}

		// If the image id of the preferred thumbnail is NOT blank, display a grid box
		if (!in_array($img_id, array('', '0')))
		{
			$src = "http://dimli.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/medium/".$img_id.".jpg&amp;h=153&amp;w=153&amp;q=70";
		?>

			<div class="gridThumb_wrapper">

				<img src="<?php echo $src; ?>"
					class="gridThumb"
					data-work="<?php echo ($arr['type'] == 'work') ? create_six_digits($id) : 'None'; ?>"
					data-image="<?php echo create_six_digits($img_id); ?>">

			</div>

		<?php
		}
		$i++;
	}
	?>

	<script  id="lantern_grid_script">

		// WRAP GRID ROWS

		lantern_wrap_imgRows();


		/*
		TOGGLE FILTER VISIBILITY
		*/
		// TEMP: Commented out while filters are not being used
		// 
		// $('#filter_toggle').unbind('click').click(function()
		// 	{
		// 		if (!$('#control_panel_wide').is(':visible'))
		// 		{
		// 			$('#control_panel_wide').slideDown(600);
		// 			$('#filter_toggle span').text('Hide Filters');
		// 			$(document).scrollTop($('body').offset().top);
		// 		}
		// 		else
		// 		{
		// 			$('#control_panel_wide').slideUp(600);
		// 			$('#filter_toggle span').text('Show Filters');
		// 		}
		// 	});


		// GRID VIEW THUMBNAILS

		$('div[id^=gridRow] div.gridThumb_wrapper')
			.unbind('click mouseenter mouseleave');

		$('div[id^=gridRow] div.gridThumb_wrapper')
			.click(
				// Prepare and call function to load the preview dropdown
				function () {
					if ($(this).find('img.gridThumb').hasClass('selected') == false)
					{
						var img = $(this).find('img.gridThumb');

						var row = $(img).parents('div.gridRow');
						var dd = $('<div>', { class: 'grid_dropdown' });
						var work = $(img).attr('data-work');
						var image = $(img).attr('data-image');

						lantern_dropdown_load(dd, row, work, image);
					}
				})
			.mouseenter(debounce(
				// After a brief delay, query the record title and display it in a thumbnail banner
				function (event) {
					var thumb = $(this).find('img.gridThumb');
					var banner = $('<div class="gridThumb_banner">').css({ width: ($(thumb).width()-10)+'px' });
					var work = $(thumb).attr('data-work');
					var image = $(thumb).attr('data-image');

					lantern_grid_loadThumbBanner(thumb, banner, work, image);
				}, 50))
			.mouseleave(
				function(event)
				// Remove the thumbnail banner
				{
					$('div.gridThumb_banner').remove();
				});


		// LOAD MORE RESULTS WHEN USER SCROLLS TO END OF LIST

		var newPage = <?php echo $page+1; ?>;
		scroll_to_load($('div#lantern_results_list'), 'grid', newPage);

	</script>

<?php
}
?>