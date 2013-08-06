<table class="catalogUI_authorityResults">

	<div class="close floatRight pointer"></div>
	
<tbody>

	<tr><td colspan="2"><?php echo $message; ?></td></tr>

	<?php
	while ($row = $result->fetch_assoc()): ?>
	
		<?php $altNames_arr = explode(' || ', $row['nonpref_term_text']); ?>

		<tr>

			<td>

				<div class="termLink mediumWeight"
					title="<?php printAltNames($altNames_arr); ?>">

					<?php echo $row['pref_term_text'];

					echo (!empty($row['pref_term_qualifier'])) 
						? ' (' . $row['pref_term_qualifier'] . ')' 
						: ''; ?>

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
</table>

<script>

	//
	//  USER SELECTS A TERM
	//
	$('table.catalogUI_authorityResults div.termLink').click(
		function()
		{
			// Find text value of the clicked term
			var term = $.trim($(this).text());
			console.log('Term: '+term);

			// Put selected term in the agent field
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
				.val(authorityId);

			// Update the selected term's popularity
			catalogUI_incrementPopularity(authorityId, 'getty_aat');

			// Remove the results list
			$(this).parents('div.resultsWrapper')
				.remove();

			$(document).scrollTop($('body').offset().top);
		});

	//
	//  CLOSE BUTTON
	//
	$('div.close').click(
		function()
		{
			$('div.resultsWrapper').remove();
		});

</script>