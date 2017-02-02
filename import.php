<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_csv_import');

/*
	Read the uploaded file and prepare it for mapping and import
*/

if (isset($_FILES['csv_file'])) {

	$temp_filename = $_FILES['csv_file']['tmp_name'];
	$csv_str = file_get_contents($temp_filename);
	$csv_str = str_replace("\n", "\r", $csv_str);
	$csv_arr = str_getcsv($csv_str);
}

/*
	Import the file
*/

if (isset($_GET['filename']) && $_GET['filename']!=='') {

	$filepath = '_uploads/'.$_GET['filename'];
	$csv_str = file_get_contents($filepath);
	$csv_arr = str_getcsv($csv_str);
	$csv_arr = array_chunk($csv_arr, $_GET['cols'] - 1);
	$col_arr = array_slice($csv_arr, 0, 1);

	print_r_pre($_POST);
	print_r_pre($csv_arr);
}

#############################################################
####################  BEGIN CLIENT-SIDE  ####################
#############################################################
require("_php/header.php"); ?>

<div id="message_wrapper">
	<div id="message_text"></div>
</div>

<div id="module_tier1">

	<div id="import_module" class="module double" style="">

		<h1>Import Records</h1>

		<?php
		if (!isset($_FILES['csv_file']) && !isset($_GET['filename'])) { ?>

			<div id="upload_wrap" style="padding: 5px 10px;">
		
				<form id="upload_form" action="import.php" method="post" enctype="multipart/form-data">

					<label for="csv_file">Upload CSV file:</label>
					<input type="file" name="csv_file" style="width: 500px;"><br>

					<button type="submit" id="upload_csv">Upload</button>

				</form>

			</div>

		<?php
		} elseif (isset($_FILES['csv_file'])) {

			$column_titles_end = strpos($csv_str, "\r");
			$column_titles_str = trim(substr($csv_str, 0, $column_titles_end)); 
				// Get string of only the column titles
			$column_titles_arr = explode(",", $column_titles_str); 
				// Explode the column titles string into an array
			$num_columns = count($column_titles_arr); 
				// Count the number of title columns in the csv

			if (file_exists('_uploads'.$_FILES['csv_file']['name'])) {
				unlink('_uploads/'.$_FILES['csv_file']['name']);
				sleep(2);
			} 

			move_uploaded_file($_FILES['csv_file']['tmp_name'], '_uploads/'.$_FILES['csv_file']['name']); ?>

			<form method="post" action="import.php?filename=<?php echo $_FILES['csv_file']['name'];?>&amp;cols=<?php echo $num_columns;?>">

				<div style="margin-bottom: 10px;padding: 10px; background-color: #C5C5FF; line-height: 1.2em;">
					<span style="font-weight: bold; line-height: 1.4em;">Filename: </span>
					<span><?php echo $_FILES['csv_file']['name']; ?></span>
					&nbsp;&nbsp;&nbsp;
					<span style="font-weight: bold; line-height: 1.4em;">Size: </span>
					<span><?php echo round($_FILES['csv_file']['size']/1000); ?> kb</span>
					&nbsp;&nbsp;&nbsp;
					<span style="font-weight: bold; line-height: 1.4em;">Type: </span>
					<span><?php echo $_FILES['csv_file']['type']; ?></span>
					<br><br>
					<span>File successfully imported. Map your CSV's fields to the appropriate fields in DIMLI's database, and choose whether the data belongs to a 'Work' or 'Image' record type.</span>
				</div>

				<table id="import_map">

					<th>CSV Column Title</th>
					<th>Record Type</th>
					<th>DIMLI Field</th>
					<th></th>
					<th>Status</th>

					<?php
					for ($i=0; $i<$num_columns; $i++) { ?>

						<tr class="import_map_row">
							
							<td class="column_title"><?php echo $column_titles_arr[$i]; ?></td>

							<td style="width: 110px;">

								<select name="<?php echo $column_titles_arr[$i];?>___type" 
									style="width: 100px;">
									
									<option value=""></option>
									<option value="Image">Image</option>
									<option value="Work">Work</option>

								</select>

							</td>

							<td>
								
								<select name="<?php echo $column_titles_arr[$i];?>___field">
									
									<option value=""></option>
									<option value="Legacy Id">Legacy Id</option>
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

							<td class="select_type_cell"></td>

							<td class="status">Will be ignored</td>

						</tr>

					<?php
					} ?>

				</table>

				<button type="submit" id="confirm_import_map">Import</button>

			</form>

		<?php
		} ?>

	</div>

	<p class="clear_module"></p>

</div>

<script>

	// Show Upload button only if the user has selected a file

	$('button#upload_csv').hide();
	$('input[name=csv_file]').change(function() {
		if ($(this).val() != '') {
			$('button#upload_csv').show();
		}
	});


	// Update row status

	$('table#import_map select').change(function() {
		var row = $(this).parents('tr.import_map_row');
		var fieldVal = row.find('select[name=dimli_field]').val();
		var typeVal = row.find('select[name=record_type]').val();
		var status = row.find('td.status');
		if (fieldVal != '' && typeVal != '') {
			status.text("Will be imported");
			row.addClass('green_highlight');
		} else {
			status.text("Will be ignored");
			row.removeClass('green_highlight');
		}
	});

</script>

<?php
require("_php/footer.php"); ?>