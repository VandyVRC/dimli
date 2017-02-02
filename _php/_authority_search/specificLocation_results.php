<table class="catalogUI_authorityResults">

	<div class="close floatRight pointer"></div>

	<tr>
		<td class="mediumWeight purple grey_bg" colspan="2"
			style="border-bottom: 1px solid #FFF;">
			<?php echo $message; ?>
		</td>
	</tr>

	<tr id="authorityResults_location_builtWork">

		<td class="mediumWeight grey_bg"
			style="border-top: 1px solid #FFF;" 
			colspan="2">

			<?php echo count($builtWorkIds_filteredOnce).' built works'; ?>

		</td>

	</tr>

	<tbody>

	<?php $i = 0; ?>

	<?php while ($i < count($builtWorkIds_filteredOnce)): ?>

		<tr>

			<td>

				<div class="termLink mediumWeight">

					<?php

					$sql = " SELECT * FROM $DB_NAME.title WHERE related_works = {$builtWorkIds_filteredOnce[$i]} ";
					$result = $mysqli->query($sql);

					$prefCount = 0;
					while ($row = $result->fetch_assoc())
					{
						if ($prefCount < 1)
						{
							$preferredName = $row['title_text'];
							$prefCount++;
						}
					}

					$sql = " SELECT * FROM $DB_NAME.title WHERE related_works = {$builtWorkIds_filteredOnce[$i]} ";
					$result = $mysqli->query($sql);

					while ($row = $result->fetch_assoc())
					{
						$preferredName = $row['title_text'];
						echo '<div class="builtWork_displayName bot_margin">'.$row['title_text'].'</div>';
					}
					?>

				</div>

				<span class="authorityId">

					<?php echo 'work'.$builtWorkIds_filteredOnce[$i]; ?>

				</span>

				<div style="color: #BBB;">

					<?php echo $row['popularity']; ?>

				</div>

			</td>

			<td>

				<div class="bot_margin">

					<?php

					$sql = " SELECT * FROM $DB_NAME.location WHERE related_works = {$builtWorkIds_filteredOnce[$i]} ";
					$result = $mysqli->query($sql);

					while ($row = $result->fetch_assoc())
					{
						echo $row['location_text'].'<br>';
					}

					?>

				</div>

				<div class="bot_margin">

					<?php

					$sql = " SELECT * FROM $DB_NAME.agent WHERE related_works = {$builtWorkIds_filteredOnce[$i]} ";
					$result = $mysqli->query($sql);

					while ($row = $result->fetch_assoc())
					{

						echo (!empty($row['agent_text'])) 
							? $row['agent_text'] : '';

						echo (!empty($row['agent_role'])) 
							? ' (' . $row['agent_role'] . ')' : '';

						?>

						<br>

					<?php
					}
					?>

				</div>

				<div class="bot_margin">

					<?php

					$sql = " SELECT * FROM $DB_NAME.date WHERE related_works = {$builtWorkIds_filteredOnce[$i]} ";
					$result = $mysqli->query($sql);

					while ($row = $result->fetch_assoc())
					{
						echo ($row['date_circa'] == 1) ? 'ca. ' : '';
						echo $row['date_text'];
						echo (
							(!empty($row['date_text']))
							&&
							$row['date_range'] == 0 // NOT a date range
							||
								(
								$row['date_range'] == 1 // IS a date range
								&&
								$row['date_era'] != $row['enddate_era'] // Start and End eras not equal
								)
							)
							? ' '.$row['date_era']
							: '';
						echo ($row['date_range'] == 1) ? ' - '.$row['enddate_text'].' '.$row['enddate_era'] : '';
						echo (!empty($row['date_text'])) ? ' ('.$row['date_type'].')' : '';
						echo '<br>';
					}

					?>

				</div>

				<div>

					<?php $sql = " SELECT * FROM $DB_NAME.work_type WHERE related_works = {$builtWorkIds_filteredOnce[$i]} ";

					$result = $mysqli->query($sql);

					while ($row = $result->fetch_assoc()):
					
						echo $row['work_type_text'];
						echo '<br>';
					
					endwhile; ?>

				</div>

			</td>

		</tr>

		<?php $i ++; ?>

	<?php endwhile; ?>

	<tr>

		<td class="mediumWeight row_highlight center_text" 
			style="height: 30px; vertical-align: middle;"
			colspan="2">
			
			<a id="createBuiltWork_link">Add a new built work to the database</a>
		
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

			// Put selected term in the built work field
			$(this).parents('div.resultsWrapper')
				.prev('div.catRowWrapper')
				.find('input[type=text]')
				.val(term);

			// Remove the results list
			$(this).parents('div.resultsWrapper')
				.remove();

			$(document).scrollTop($('body').offset().top);
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