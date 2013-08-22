<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();

if (isset($_FILES['csv_file'])) {
	$temp_filename = $_FILES['csv_file']['tmp_name'];
	$csv_str = file_get_contents($temp_filename);
	$csv_str = str_replace("\n", "\r", $csv_str);
	$csv_arr = str_getcsv($csv_str);
}

###########################################################
##################  BEGIN CLIENT-SIDE  ####################
###########################################################
require("_php/header.php"); ?>

<div id="message_wrapper">
	<div id="message_text"></div>
</div>

<div id="module_tier1">

	<div id="import_module" class="module double">

		<h1>Import Existing Records</h1>

		<?php 
		if (!isset($_FILES['csv_file'])) { ?>

			<div id="upload_wrap" style="padding: 5px 10px;">
		
				<form id="upload_form" action="import.php" method="post" enctype="multipart/form-data">

					<label for="csv_file">Upload CSV file:</label>
					<input type="file" name="csv_file" style="width: 500px;"><br>

					<button type="submit" id="upload_csv">Upload</button>

				</form>

			</div>

		<?php
		} elseif (isset($_FILES['csv_file'])) { ?>

			<table id="import_map">

				<th>CSV Column Title</th>
				<th>Record Type</th>
				<th>DIMLI Field</th>

				<?php
				$column_titles_end = strpos($csv_str, "\r");
				$column_titles_str = 
					trim(substr($csv_str, 0, $column_titles_end)); // Get string of only the column titles
				$column_titles_arr = 
					explode(",", $column_titles_str); // Explode the column titles string into an array
				$num_columns = 
					count($column_titles_arr); // Count the number of title columns in the csv

				for ($i=0; $i<$num_columns; $i++) { ?>

					<tr class="import_map_row">
						
						<td class="column_title"><?php echo $column_titles_arr[$i]; ?></td>

						<td style="width: 110px;">

							<select style="width: 100px;">
								
								<option value=""></option>
								<option value="Image">Image</option>
								<option value="Work">Work</option>

							</select>

						</td>

						<td>
							
							<select>
								
								<option value=""></option>
								<option value="Title">Title</option>
								<option value="Agent">Agent</option>
								<option value="Date">Date</option>
								<option value="Material">Material</option>
								<option value="Technique">Technique</option>
								<option value="Work Type">Work Type</option>
								<option value="Cultural Context">Cultural Context</option>
								<option value="Style Period">Style Period</option>
								<option value="Location">Location</option>
								<option value="Description">Description</option>
								<option value="State/Edition">State/Edition</option>
								<option value="Measurements">Measurements</option>
								<option value="Subject">Subject</option>
								<option value="Inscription">Inscription</option>
								<option value="Rights">Rights</option>
								<option value="Source">Source</option>

							</select>

						</td>

					</tr>

				<?php
				} ?>

			</table>

		<?php
		} ?>

	</div>

	<p class="clear_module"></p>

</div>

<script>

$('button#upload_csv').hide();
$('input[name=csv_file]').change(function() {
	if ($(this).val() != '') {
		$('button#upload_csv').show();
	}
});

</script>

<?php require("_php/footer.php"); ?>