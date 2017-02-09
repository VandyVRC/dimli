<table class="catalogUI_authorityResults">

	<div class="close floatRight pointer"></div>

	<tr id="authorityResults_location_tgn" style="border-bottom: 1px solid #FFF;">
		<td class="mediumWeight grey_bg" colspan="2" > 
			<?php echo $resultCount_tgn;?>
			<?php echo ($resultCount_tgn != 1) ? ' TGN terms, ': 'TGN term, '; ?>
			<span class="mediumWeight purple grey_bg">
			<?php echo $message; ?>
			</span>
		</td>
	</tr>
	
	<tbody>

	<?php while ($row = $result->fetch_assoc()): ?>
	
		<?php
		// Create array of alternate terms
		$altNames_arr = explode(' || ', $row['nonpref_term']);
		// Add preferred term to array of alternate terms if an english term exists
		if ($row['english_pref_term'] != "") {
			$altNames_arr = array_merge(array($row['getty_pref_term']), $altNames_arr);
		} ?>
	
		<tr>

			<td>

				<div class="termLink mediumWeight"
					title="<?php printAltNames($altNames_arr); ?>">

					<?php
					// Display english preferred term, if it exists.
					// Otherwise, display getty preferred term.
					echo ($row['english_pref_term'] != "")
						? $row['english_pref_term']
						: $row['getty_pref_term'];

					echo (!empty($row['pref_place_type'])) 
						? " (" . $row['pref_place_type'] . ")" 
						: ""; ?>

				</div>

				<span class="authorityId"><?php echo $row['getty_id']; ?></span>

				<div style="color: #BBB;">

					<?php echo $row['popularity']; ?>

				</div>

			</td>

			<td>

				<div class="bot_margin" style="font-size: 0.9em;">

					<?php echo $row['note_text']; ?>

				</div>

				<div>

					<?php printHierarchy($row['hierarchy'], false); ?>

				</div>

			</td>

		</tr>

	<?php endwhile; ?>

	</tbody>
	
		<tr id="authorityResults_location_repository">
		<td class="mediumWeight grey_bg"
			style="border-top: 1px solid #FFF; border-bottom: 1px solid #FFF;" 
			colspan="2">
			<?php echo $result_repository->num_rows; ?>
			<?php echo ($result_repository->num_rows !=1) ? ' repositories' : ' repository';?>
		</td>
	</tr>

	<tbody>

	<?php while ($row = $result_repository->fetch_assoc()): ?>

		<tr>

			<td>

				<div class="termLink mediumWeight">

					<?php echo $row['museum']; ?>

				</div>

				<span class="authorityId"><?php echo 'rep'.$row['id']; ?></span>

				<div style="color: #BBB;">

					<?php echo $row['popularity']; ?>

				</div>

			</td>

			<td>

				<div class="bot_margin" style="font-size: 0.9em;">

					<?php echo $row['city']; ?>

				</div>

				<div>

					<?php echo $row['country']; ?>

				</div>

			</td>

		</tr>

	<?php endwhile; ?>

	<tr>

		<td class="mediumWeight row_highlight center_text" 
			style="height: 30px; vertical-align: middle;"
			colspan="2">

			<a id="createRepository_link">Add a new repository to the list</a>

		</td>

	</tr>

	</tbody>

</table>

<script>

	//
	//  USER SELECTS TERMS
	//
	$('table.catalogUI_authorityResults div.termLink').click(
		function()
		{
			// Find text value of the clicked term
			if ($(this).has('div.builtWork_displayName').length)
			{
				var term = $.trim($(this).find('div.builtWork_displayName:first').text());
			}
			else
			{
				var term = $.trim($(this).text());
			}
			console.log('Term: '+term);

			// Put selected term in the location field
			$(this).parents('div.resultsWrapper')
				.prev('div.catRowWrapper')
				.find('input[type=text]')
				.val(term);

			// Find authority id of the selected term
			var authorityId = $(this).next('span.authorityId').text();

			// Put authority id in the hidden field
			$(this).parents('div.resultsWrapper')
				.prev('div.catRowWrapper')
				.find('input[type=hidden]:not(.cat_display)')
				.val($.trim(authorityId));

			if (authorityId.indexOf('rep') >= 0)
			{
				var authorityTableToUpdate = 'repository';
			}
			else
			{
				var authorityTableToUpdate = 'getty_tgn';
			}

			// Update the selected term's popularity
			catalogUI_incrementPopularity(authorityId, authorityTableToUpdate);

			// Remove the results list
			$(this).parents('div.resultsWrapper')
				.remove();

			$(document).scrollTop($('body').offset().top);
		});

	$('a#createRepository_link').click(
		function()
		{
			$('div.resultsWrapper').remove();
			createRepository();
		});

	$('a#createBuiltWork_link').click(
		function()
		{
			$('div.resultsWrapper').remove();
			createBuiltWork();
		});

	$('div.close').click(
		function()
		{
			$('div.resultsWrapper').remove();
		});

</script>