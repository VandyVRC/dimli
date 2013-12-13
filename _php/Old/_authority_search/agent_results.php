<table class="catalogUI_authorityResults">

	<div class="close floatRight pointer"></div>
	
<tbody>

	<tr><td colspan="2"><?php echo $message; ?></td></tr>

	<?php

	while ($row = $result->fetch_assoc())
	{
		$altNames_arr = explode(' || ', $row['nonpref_term']);
		$altRoles_arr = explode(' || ', $row['nonpref_role_type']);
		
		?>

		<tr>

			<td>

				<div class="termLink bot_margin mediumWeight"
					title="<?php printAltNames($altNames_arr); ?>">

					<?php echo $row['pref_term']; ?>

				</div>

				<span class="authorityId"><?php echo $row['getty_id']; ?></span>

				<div>

					<input type="checkbox" 
						name="agentRole[]" 
						value="<?php echo $row['pref_role_type']; ?>"><?php echo $row['pref_role_type']; ?>
					<br>

					<?php 
					if (!empty($altRoles_arr) && $altRoles_arr != array(''))
					{
						foreach ($altRoles_arr as $role)
						{
						?>
							<input type="checkbox" 
								name="agentRole[]" 
								value="<?php echo $role; ?>"><?php echo $role; ?>
							<br>
						<?php
						}
					}
					?>

				</div>

			</td>

			<td>

				<div class="bot_margin">

					(<?php echo $row['pref_nationality_type'] . ' ' . $row['record_type']; ?>)

				</div>

				<div style="font-size: 0.9em;">

					<?php echo $row['pref_bio_text']; ?>

				</div>

			</td>

		</tr>

	<?php
	}
	?>

</tbody>
</table>

<script>

	//
	// THE USER SELECTS A TERM
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
			catalogUI_incrementPopularity(authorityId, 'getty_ulan');

			var role_arr = [];

			// For each checked agent role
			$(this).parents('tr').find('input[type=checkbox]:checked').each(
				function()
				{
					// Add role to array
					role_arr.push($(this).val());
				});

			// Create string of agent roles
			var role_str = role_arr.join('; ');

			// Put selected roles in the roles field
			$(this).parents('div.resultsWrapper')
				.prev('div.catRowWrapper')
				.prev('div.catRowWrapper')
				.find('input[type=text]')
				.css({ color: '#555' })
				.val(role_str);

			// Remove the results list
			$(this).parents('div.resultsWrapper')
				.remove();

			$(document).scrollTop($('body').offset().top);
		});

	//
	// CLOSE BUTTON
	//
	$('div.close').click(
		function()
		{
			$('div.resultsWrapper').remove();
		});

</script>