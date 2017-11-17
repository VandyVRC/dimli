<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

if (
	($_POST['title'] == '') 
	&& 
	($_POST['agent'] == '')
) {

	echo 'blank search';
}

$relation = (isset($_POST['relation']) && $_POST['relation'] == 'yes')
? 'yes'
: 'no';

//------------------------------------------------------------
//		Build Title Term Array and Perform Title Search
//------------------------------------------------------------

if ($_POST['title'] != '') {
// If 'Title' field was not submitted empty

	$seperators = array(' ', "'", '"', '(', ')', '-', '&', '`', '%', ':', '+', '=', '/', '.', ',');
	// Define list of characters that will be stripped from search string

	$title = str_replace($seperators, ' ', trim($_POST['title']));
	// Trim and strip special characters from search string

	$titleArray = explode(' ', $title);
	// Explode string into array

	$titleArray = array_filter($titleArray, 'filterNonSearchTerms');
	// Apply filter to omit short and general search terms
	
	// Begin building query
	$titleQuery = "SELECT * 
						FROM DB_NAME.title 
						WHERE related_works <> '' && ( ";

	foreach ($titleArray as $term) {
		$titleQuery .= " title_text LIKE '%{$term}%' || ";
	}
	// Build query for each term in title terms array

	$titleQuery .= " title_text = '*****' ) ORDER BY title_text ";
	// Finish the query

	$titleResult = db_query($mysqli, $titleQuery);
	
}

//----------------------------------
//		Build Agent Term Array
//----------------------------------

if ($_POST['agent'] != '') {
// If 'Agent' field was not submitted empty

	$seperators = array(' ', "'", '"', '(', ')', '-', '&', '`', '%', ':', '+', '=', '/', '.', ',');
	// Define list of characters that will be stripped from search string

	$agent = str_replace($seperators, ' ', trim($_POST['agent']));
	// Trim and strip special characters from search string

	$agentArray = explode(' ', $agent);
	// Explode string into array

	$agentArray = array_filter($agentArray, 'filterNonSearchTerms');
	// Apply filter to omit short and general search terms
	
}

//-----------------------------------------------
//		Perform Combined Title/Agent Search
//-----------------------------------------------

if ($_POST['title'] != '' && $_POST['agent'] != '') {
	
	while ($row = $titleResult->fetch_assoc()) {
	// Check each work with a matching title for matching agents

		// Begin building query
		$agentQuery = "SELECT * 
							FROM DB_NAME.agent 
							WHERE related_works = '{$row['related_works']}' && ( ";

		foreach ($agentArray as $term) {
			$agentQuery .= " agent_text LIKE '%{$term}%' || ";
		}
		// Build query for each term in agent terms array

		$agentQuery .= " agent_text = '*****' ) ORDER BY agent_text ";
		// Finish the query

		$agentResult = db_query($mysqli, $agentQuery);
		
		if (isset($agentResult)) {
			while ($row = $agentResult->fetch_assoc()) {
				$matchingWorks[] = $row['related_works'];
			}
		}

	}
	
//-------------------------------------
//		Perform Agent Search Only
//-------------------------------------
	
} elseif ($_POST['title'] == '' && $_POST['agent'] != '') {

	// Begin building query
	$agentQuery = "SELECT * 
						FROM DB_NAME.agent 
						WHERE related_works <> '' && ( ";

	foreach ($agentArray as $term) {
		$agentQuery .= " agent_text LIKE '%{$term}%' || ";
	}
	// Build query for each term in search terms array

	$agentQuery .= " agent_text = '*****' ) ORDER BY agent_text ";
	// Finish the query

	$agentResult = db_query($mysqli, $agentQuery);
	// Perform query
	
	if (isset($agentResult)) {
		while ($row = $agentResult->fetch_assoc()) {
			$matchingWorks[] = $row['related_works'];
		}
	}

}

if ($_POST['title'] != '' && $_POST['agent'] == '') {

	if (isset($titleResult)) {
		while ($row = $titleResult->fetch_assoc()) {
			$matchingWorks[] = $row['related_works'];
		}
	}
	
}

if (!empty($matchingWorks)) {

	$matchingWorks = array_unique($matchingWorks);
	// Remove duplicate IDs from list of results

	if ($relation =='yes') 
	{ ?>

		<div id="workAssoc_results_header" class="defaultCursor">

		Click a related work below 
		<span class="close pointer" 
		style="color: #669; font-size: 1.2em;">&nbsp;x&nbsp;</span>

		</div><?php 
	}

	else
	{ ?>

		<div id="workAssoc_results_header" class="defaultCursor">

			Click a work below to associate it with the current image record
			<span class="close pointer" 
				style="color: #669; font-size: 1.2em;">&nbsp;x&nbsp;</span>

		</div><?php 
	}

	foreach ($matchingWorks as $workId) 
	{ 
			
		$sql = "SELECT preferred_image 
					FROM DB_NAME.work 
					WHERE id = {$workId} ";

		$result = db_query($mysqli, $sql);

			while ($work_thumb = $result->fetch_assoc())
			{
				$prefImage = $work_thumb['preferred_image'];
			}

			$sql = "SELECT legacy_id
						FROM DB_NAME.image
						WHERE id = '{$prefImage}' ";

			$leg_id_res = db_query($mysqli, $sql);

			while ($leg_id = $leg_id_res->fetch_assoc()){

				$legacyId = $leg_id['legacy_id'];

				$prefImage_file = $image_dir.'thumb/'.$legacyId.'.jpg';
			}

			$sql = "SELECT title_text 
						FROM DB_NAME.title 
						WHERE related_works = '{$workId}' ";

			$title_result = db_query($mysqli, $sql);

			$sql = "SELECT agent_text 
						FROM DB_NAME.agent 
						WHERE related_works = '{$workId}' ";

			$agent_result = db_query($mysqli, $sql);

			$sql = "SELECT * 
						FROM DB_NAME.date 
						WHERE related_works = '{$workId}' LIMIT 2 ";

			$date_result = db_query($mysqli, $sql);

			$sql = "SELECT culture_text 
						FROM DB_NAME.culture 
						WHERE related_works = '{$workId}' LIMIT 2 ";

			$culture_result = db_query($mysqli, $sql); 

			$i=0;

				?>
					<div class="workAssoc_results_row">
				
						<input type="hidden" 

							id="workNum<?php echo $i;?>"
							name="workNum<?php echo $i;?>"
							value="<?php echo $workId; ?>">

						<input type="hidden" 
							id="imageNum<?php echo $i;?>"
							name="imageNum<?php echo $i;?>"
							value="<?php echo $prefImage; ?>">

						<input type="hidden" 
							id="imageView<?php echo $i;?>" 
							name="imageView<?php echo $i;?>" 

							value="<?php echo $legacyId; ?>">
					
						<!--
							Preview thumbnail
						-->
						
						<div class="workAssoc_results_col1">
						
						<?php 
						
							if ($prefImage == '') 
							{ ?>

								<div class="record_thumbnail"
								style="margin-right: 5px;">No preview</div>
								
					<?php }

							else 
							{ ?>
								<img src="<?php echo $prefImage_file;?>"
									class="workAssoc_thumb"
									title="Preview this image"
									style="display: inline-block; width: 92px;">

					<?php } ?>		
							
						</div>

						<div class="workAssoc_results_col2 defaultCursor">
						
							<!--
								Work title
							-->
								
								<div class="workAssoc_results_cell mediumWeight">

									<?php
									while ($row = $title_result->fetch_assoc())
									{
										echo '<span title="'.$row['title_text'].'">';
										echo (strlen($row['title_text']) <= 46) 
											? $row['title_text'] . '<br>'
											: substr($row['title_text'], 0, 43) . '...<br>';
										echo '</span>';
									}
									?>

							</div>
							
							<!--
								Agent
							-->
							
							<div class="workAssoc_results_cell">

								<?php
								while ($row = $agent_result->fetch_assoc())
								{
									echo $row['agent_text'] . '<br>';
								} ?>

							</div>
							
							<!--
								Date
							-->
							
							<div class="workAssoc_results_cell"
								style="font-size: 0.9em;">
							
								<?php if ($date_result->num_rows != 0) { ?>
								<!-- If a date exists in the database -->
								
									<?php while ($row = $date_result->fetch_assoc()) { ?>
										
										<?php echo ($row['date_circa'] == '1') ? 'ca.' : ''; ?>
										<?php echo $row['date_text']; ?>
										<?php echo ((!empty($row['date_text'])) && ($row['date_range'] == 0 || ($row['date_range'] == 1 && $row['date_era'] != $row['enddate_era']))) ? $row['date_era'] : ''; ?>
										<?php echo ($row['date_range'] == '1') ? ' - ' : ''; ?>
										<?php echo ($row['date_range'] == '1') ? $row['enddate_text'] : ''; ?>
										<?php echo ($row['date_range'] == '1') ? $row['enddate_era'] : ''; ?>
										<?php echo (!empty($row['date_text'])) ? '(' . $row['date_type'] . ')' : ''; ?>
										<?php if ($date_result->num_rows == 2) { ?><br><?php } ?>
										
									<?php } ?>
									
								<?php } ?>

							</div>
							
							<!--
								Culture
							-->
							
							<div class="workAssoc_results_cell"
								style="font-size: 0.9em;">
							
								<?php 
								if ($culture_result->num_rows != 0) {
								
									$culture_i = 1;
									while ($row = $culture_result->fetch_assoc()) 
									{
										if ($culture_i == 2)
										{
											echo ', ';
										}
										echo $row['culture_text'];
										$culture_i++;
									}
								}
								?>

							</div>

						</div>
						
					</div> <!-- workAssoc_results_row -->
		<?php	
	}	
}

else 
{	
	if ($relation == 'yes') 
	{ ?>
		<div>
		Your search yielded no matching work records.
		</div><?php
	}				

	else 
	{ ?>

	<div>
		Your search yielded no matching work records. Yours is the first for this work - make it good!
	</div><?php 
	}

}?>

<script>

	$('div.workAssoc_results_row').hover(
		function()
		{
			$(this).addClass('row_highlight');
		}, 
		function()
		{
			$(this).removeClass('row_highlight');
		});


	$('div.workAssoc_results_row:not(img)').click(
		function(event)
		{
			var row = $(this);
			var thisRow = $(this).parents('div.clone_wrap');
			var workNum = $(row).find('input[name*=workNum]').val();
			var imageNum = "<?php echo $_SESSION['imageNum']; ?>";
			var orderNum = "<?php echo $_SESSION['order']; ?>";

			if (thisRow.length){
				$(row).removeClass('row_highlight');    
				relationAssoc_assoc(row, workNum);
			}

			else{

				workAssoc_assoc(orderNum, workNum, imageNum);
				
			}

		});
			
	$('img.workAssoc_thumb').click(
		function(event)
		{
			event.stopPropagation();

			var imageView = $(this).parents('div.workAssoc_results_row')
			.find('input[name*=imageView]').val();
			
			image_viewer(imageView);	
		});


	var imageNum = $(this).parents('div.workAssoc_results_row').find('input[name*=imageNum]').val();

	$('div#workAssoc_results_header span.close').click(
		function()
		{
			$('div#workAssoc_results').remove();
		});

</script>

