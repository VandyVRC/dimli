<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_csv_export');

// print_r($_POST); // Debugging
// print_r($_SESSION); // Debugging

//------------------------------------------------
//  ## DIMLI database to CSV Export script ##
//  Matthew Isner (matthew.isner@vanderbilt.edu)
//  Updated 25 July 2013
//------------------------------------------------


// Define array of flagged images, and number to export
$exportFlagged_count = count($_SESSION['flaggedImages']);
$flaggedImages_str = '';
foreach ($_SESSION['flaggedImages'] as $key=>$val) {
	$flaggedImages_str .= $val . ',';
}
$flaggedImages_str = rtrim($flaggedImages_str, ', ');

// Initialize master array to store csv data
$csvArray = array();
$fields = explode(',', $_GET['fields']);

//-----------------------------------------------------
// Build query to select either an id range, or a list
// depending on the user's selection
//-----------------------------------------------------
if (isset($_GET['type']) && $_GET['type'] == 'range')
{

// User enetered a range of image records
// Define first and last records to export
$start = $_GET['first'];
$end = $_GET['last'];

	$sql = "SELECT * FROM $DB_NAME.image 
				WHERE id BETWEEN {$start} AND {$end} ";

	// Establish query fragment to be used below 
	// to update images records after export is complete
	$updateThese = "id BETWEEN {$start} AND {$end}";

	// Define filename for the CSV to be output.
	// Will be used below.
	$filename = "dimli_exportToCSV__". $start ."-". $end ."__". date('Y.m.d') .".csv";

}
elseif (isset($_GET['type']) && $_GET['type'] == 'flagged')
{
// User exported all flagged and approved images

	$sql = "SELECT * FROM $DB_NAME.image 
				WHERE id IN({$flaggedImages_str}) ";

	// Establish query fragment to be used below 
	// to update images records after export is complete
	$updateThese = " id IN({$flaggedImages_str}) ";

	// Define filename for the CSV to be output.
	// Will be used below.
	$filename = "dimli_exportToMdid__FlaggedApproved__". date('Y.m.d');

}

$result = db_query($mysqli, $sql);
$i = 0; 
$stop = $result->num_rows;

ob_start();

while ($row = $result->fetch_assoc())
// Iterate through each image record
{

	if ($i == $stop) break;

	$imageId = create_six_digits($row['id']);
	$legacyId = $row['legacy_id'];
	$fileFormat = $row['file_format'];
	$imageDescription = $row['description'];
	$workId = (!empty($row['related_works']))
			? create_six_digits($row['related_works'])
			: 'None';
	// Determine this row's image and associated work IDs

	foreach ($fields as $field)
	{	

		if ($field == 'title')
		{	

			//-------------------------
			//		Image titles
			//-------------------------

			$imageTitle_array = array(); // Initalize array for image titles
			$sql = "SELECT * FROM $DB_NAME.title 
						WHERE related_images = '{$imageId}' ";
			$result_imageTitle = db_query($mysqli, $sql);
			
			if ($result_imageTitle->num_rows > 0) {
			// Query found at least one image title
			
				while ($title = $result_imageTitle->fetch_assoc()) {
				
					// Add each image title to the temp array
					$imageTitle_array[] = ($title['title_text'] != '') 
							? $title['title_text'] . ' (' . $title['title_type'] . ')' 
							: 'None';
					
				}

				$result_imageTitle->free();
				
			} else { // Query found no image titles
			
				// Add each image title to the temp array
				$imageTitle_array[] = 'None';	
			
			}
			
			$imageTitle_string = implode('; ', $imageTitle_array);
			// Implode temp image title array into a string
			
			//-------------------------
			//		Work titles
			//-------------------------
			
			if ($workId != 'None') {
			// This image record has an associated work that is not blank
			
			$workTitle_array = array(); // Initalize array for work titles
			$sql = "SELECT * FROM $DB_NAME.title 
						WHERE related_works = '{$workId}' ";
			$result_workTitle = db_query($mysqli, $sql);
			
			if ($result_workTitle->num_rows > 0) {
			// Query found at least one work title
			
				while ($title = $result_workTitle->fetch_assoc()) {
				
					// Add each work title to the temp array
					$workTitle_array[] = ($title['title_text'] != '') 
							? $title['title_text'] . ' (' . $title['title_type'] . ')' 
							: 'None';
					
				}

				$result_workTitle->free();
			
			} else { // Query found no work titles
			
				$workTitle_array[] = 'None';
				// Add each work title to the temp array
			
			}
			
			$workTitle_string = implode('; ', $workTitle_array);
			// Implode temp work title array into a string
			
			} else { // This image record has no associated work yet
			
				$workTitle_string = 'None';
			
			}
		}	

		elseif ($field == 'agent')
		{	
			//---------------------
			//		Agents
			//---------------------

			$agent_array = array(); // Initilize array for agents

			$sql = "SELECT * FROM $DB_NAME.agent 
						WHERE related_images = '{$imageId}' ";

			// If this image has an associated work
			if ($workId != 'None') {
				// Select agents from work record as well
				$sql.= " || related_works = '{$workId}' ";
			}

			$result_agent = db_query($mysqli, $sql);
			
			if ($result_agent->num_rows > 0) {
			// Query found at least one agent for this image or work record
			
				$super_nonprefTerms_array = array();
			
				while ($agent = $result_agent->fetch_assoc()) {
				// For each individual agent in the work and image records
				
					// "School of"
					$attribution = ($agent['agent_attribution'] != 'None') 
						? $agent['agent_attribution'] . ' ' 
						: '';

					// "Cezanne, Paul"
					$agentText = (!empty($agent['agent_text'])) 
						? $agent['agent_text'] 
						: '';

					// "artist, painter"
					$agentRole = (!empty($agent['agent_role'])) 
						? str_replace(';', ',', $agent['agent_role']) 
						: '';

					// "School of Cezanne, Paul"...
					$agentText_forArray = (!empty($agentText)) 
						? $attribution . $agentText 
						: '';

					// ..."(artist, painter)"
					$agentText_forArray .= (!empty($agentRole)) 
						? ' (' . $agentRole . ')' 
						: '';
					
					$agent_array[] = (!empty($agentText_forArray)) 
						? $agentText_forArray 
						: '';

					// Add each agent to the temp agent array
					$agent_array = array_filter($agent_array, 'notEmpty');
					
					if (!empty($agent['agent_getty_id'])) {
						// This agent record has a Getty id
					
						$sql = "SELECT english_pref_term, nonpref_term
									FROM $DB_NAME.getty_ulan
									WHERE getty_id = '{$agent['agent_getty_id']}' ";
						$result_altAgents = db_query($mysqli, $sql);
						
						while ($nonprefTerm = $result_altAgents->fetch_assoc()) {
						
							$nonprefTerms_array = explode(' || ', $nonprefTerm['nonpref_term']);

							if (trim($nonprefTerm['english_pref_term']) != '') { 
								$nonprefTerms_array[] = $nonprefTerm['english_pref_term']; 
							}
							
						}
						
						$nonprefTerms_array = array_filter($nonprefTerms_array, 'notEmpty');
						$super_nonprefTerms_array = array_unique(array_merge($super_nonprefTerms_array, $nonprefTerms_array));
					
					}
					
				}

				$result_agent->free();

				// Define final string of unique, non-preferred agent names
				$super_nonprefAgent_string = preg_replace('/; $/', '', implode('; ', $super_nonprefTerms_array));
				
				$agent_array = array_unique(array_filter($agent_array, 'notEmpty'));
				
				// Define the final agent string
				$agent_string = preg_replace('/; $/', '', implode('; ', $agent_array));
				
				// If final agent string is empty, change value to 'None'
				if (trim($agent_string) == '') { 
					$agent_string = 'None'; 
				}
			
			} else {
			// Query found no agents for this image or work record
			
				$agent_string = 'None';
				$super_nonprefAgent_string = 'None';
			
			}
		}
		
		elseif ($field == 'date')
		{		

			//---------------------
			//		Date
			//---------------------

			$date_array = array(); // Initilize array for dates

			$sql = "SELECT * FROM $DB_NAME.date 
						WHERE related_images = '{$imageId}' ";

			// Select work agents as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_date = db_query($mysqli, $sql);
			
			if ($result_date->num_rows > 0) {
			// Query found at least one date for this image or work record
			
				while ($date = $result_date->fetch_assoc()) {
				// Iterate through each image/work date row
				
					if (empty($date['date_text']) || $date['date_text'] == '') {
					// If this row has no date, skip to next row
					
					} else {
					
						// "ca. "
						$date_temp = ($date['date_circa'] == '1') 
							? 'ca. ' 
							: '';

						// "1982 CE"
						$date_temp.= $date['date_text'] . ' ' . $date['date_era'];

						// " - "
						$date_temp.= ($date['date_range'] == '1') 
							? ' - ' 
							: '';

						// "2013 CE"
						$date_temp.= (!empty($date['enddate_text'])) 
							? $date['enddate_text'] . ' ' . $date['enddate_era'] 
							: '';

						// " (Inclusive)"
						$date_temp.= ' (' . $date['date_type'] . ')';

						$date_array[] = $date_temp;
						$date_array = array_filter($date_array, 'notEmpty');
					
					}
				
				}

				$result_date->free();
				
				$date_array = array_filter($date_array, 'notEmpty');
				$date_string = preg_replace('/; $/', '', implode('; ', $date_array));
				if (trim($date_string) == '') { 
					$date_string = 'None'; 
				}
			
			} else {
			// Query found no dates for this image or work record
			
				$date_string = 'None';
			
			}
		
		}		
		elseif ($field == 'technique')
		{	
			//----------------------
			//		Techniques
			//----------------------
			
			$technique_array = array();

			$sql = "SELECT * FROM $DB_NAME.technique 
						WHERE related_images = '{$imageId}' ";

			// Select work techniques as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_technique = db_query($mysqli, $sql);
			
			if ($result_technique->num_rows > 0) {
			// Query found at least one technique for this image or work record
			
				$super_technique_array = array();
				
				while ($technique = $result_technique->fetch_assoc()) {
				// Iterate through each technique row
				
					$technique_array[] = $technique['technique_text'];
					
					if (!empty($technique['technique_getty_id'])) {
					// This technique row has a Getty id
					
						$sql = "SELECT english_pref_term, nonpref_term_text
									FROM $DB_NAME.getty_aat
									WHERE getty_id = '{$technique['technique_getty_id']}' 
									";
						$result_altTechniques = db_query($mysqli, $sql);
						
						while ($nonprefTechnique = $result_altTechniques->fetch_assoc()) {
						
							$nonprefTechnique_array = explode(' || ', $nonprefTechnique['nonpref_term_text']);

							if (trim($nonprefTechnique['english_pref_term']) != '') { 
								$nonprefTechnique_array[] = $nonprefTechnique['english_pref_term']; 
							}
						
						}
						
						$nonprefTechnique_array = array_filter($nonprefTechnique_array, 'notEmpty');

						$super_technique_array = array_merge($super_technique_array, $nonprefTechnique_array);
					
					}
					
					$technique_array = array_filter($technique_array, 'notEmpty');
					$technique_string = preg_replace('/; $/', '', implode('; ', $technique_array));

					if (trim($technique_string) == '') { 
						$technique_string = 'None'; 
					}
					
					$super_technique_string = preg_replace('/; $/', '', implode('; ', $super_technique_array));
				
				}

				$result_technique->free();
			
			} else {
			// Query found no techniques for this image or work record
			
				$technique_string = 'None';
			
			}
		}
		elseif ($field == 'worktype')
		{	
			//----------------------
			//		Work Type
			//----------------------
			
			$worktype_array = array();

			$sql = "SELECT * FROM $DB_NAME.work_type 
						WHERE related_images = '{$imageId}' ";

			// Select work_types from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_worktype = db_query($mysqli, $sql);
			
			if ($result_worktype->num_rows > 0) {
			// Query found at least one work_type for this image or work record
			
				$super_worktype_array = array();
				
				while ($worktype = $result_worktype->fetch_assoc()) {
				// Iterate through each work_type row
				
					$worktype_array[] = $worktype['work_type_text'];
					
					if (!empty($worktype['work_type_getty_id'])) {
					// This work_type row has a Getty id
					
						$sql = "SELECT english_pref_term, nonpref_term_text
									FROM $DB_NAME.getty_aat
									WHERE getty_id = '{$worktype['work_type_getty_id']}' ";

						$result_altWorktypes = db_query($mysqli, $sql);
						
						while ($nonprefWorktype = $result_altWorktypes->fetch_assoc()) {
						
							$nonprefWorktype_array = explode(' || ', $nonprefWorktype['nonpref_term_text']);

							if (trim($nonprefWorktype['english_pref_term']) != '') { 
								$nonprefWorktype_array[] = $nonprefWorktype['english_pref_term']; 
							}
						
						}
						
						$nonprefWorktype_array = array_filter($nonprefWorktype_array, 'notEmpty');

						$super_worktype_array = array_merge($super_worktype_array, $nonprefWorktype_array);
					
					}
					
					$worktype_array = array_filter($worktype_array, 'notEmpty');
					$worktype_string = preg_replace('/; $/', '', implode('; ', $worktype_array));

					if (trim($worktype_string) == '') { 
						$worktype_string = 'None'; 
					}
					
					$super_worktype_string = preg_replace('/; $/', '', implode('; ', $super_worktype_array));
				
				}

				$result_worktype->free();
			
			} else {
			// Query found no worktypes for this image or work record
			
				$worktype_string = 'None';
			
			}
		}
		elseif ($field == 'material')
		{	
			//----------------------
			//		Material
			//----------------------
			
			$material_array = array();

			$sql = "SELECT * FROM $DB_NAME.material 
						WHERE related_images = '{$imageId}' ";

			// Select materials from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_material = db_query($mysqli, $sql);
			
			if ($result_material->num_rows > 0) {
			// Query found at least one material for this image or work record
			
				$super_material_array = array();
				
				while ($material = $result_material->fetch_assoc()) {
				// Iterate through each material row
				
					$material_array[] = (!empty($material['material_text'])) ? $material['material_text'] . ' (' . $material['material_type'] . ')' : '';
					
					if (!empty($material['material_getty_id'])) {
					// This material row has a Getty id
					
						$sql = "SELECT english_pref_term, nonpref_term_text
									FROM $DB_NAME.getty_aat
									WHERE getty_id = '{$material['material_getty_id']}' ";

						$result_altMaterials = db_query($mysqli, $sql);
						
						while ($nonprefMaterial = $result_altMaterials->fetch_assoc()) {
						
							$nonprefMaterial_array = explode(' || ', $nonprefMaterial['nonpref_term_text']);

							if (trim($nonprefMaterial['english_pref_term']) != '') { 
								$nonprefMaterial_array[] = $nonprefMaterial['english_pref_term']; 
							}
						
						}
						
						$nonprefMaterial_array = array_filter($nonprefMaterial_array, 'notEmpty');

						$super_material_array = array_merge($super_material_array, $nonprefMaterial_array);
					
					}
					
					$material_array = array_filter($material_array, 'notEmpty');
					$material_string = preg_replace('/; $/', '', implode('; ', $material_array));

					if (trim($material_string) == '') { 
						$material_string = 'None'; 
					}
					
					$super_material_string = preg_replace('/; $/', '', implode('; ', $super_material_array));
				
				}

				$result_material->free();
			
			} else {
			// Query found no materials for this image or work record
			
				$material_string = 'None';
			
			}
		}
		elseif ($field == 'measurements')
		{	
			
			//-----------------------------
			//		Work Measurements
			//-----------------------------
			
			$workMeasure_array = array();

			$basicMeasurementTypes = array('Area','Bit depth','Circumference','Count','Depth','Diameter','Distance between','File size','Height','Length','Scale','Size','Weight','Width','Other');

			$basicUnitMeasurements = array('Circumference','Depth','Diameter','Distance between','Height','Length','Width');

			$sql = "SELECT * FROM $DB_NAME.measurements 
						WHERE related_works = '{$workId}' ";

			$result_workMeasure = db_query($mysqli, $sql);
			
			if ($result_workMeasure->num_rows) {
			// Query found at least one measurement for this work record
			
				while ($measure = $result_workMeasure->fetch_assoc()) {
				// Iterate through each measurement row
				
					$measure_temp = '';
					
					if (in_array($measure['measurements_type'], $basicMeasurementTypes)) {
					// Meaasurement is a basic type that uses the normal text input field
					
						$measure_temp = $measure['measurements_text'];
						
						if ($measure['measurements_type'] == 'Area') {
							$measure_temp .= ' ' . $measure['area_unit'];
							
						} elseif ($measure['measurements_type'] == 'Bit depth') {
							$measure_temp .= ' bit';
						
						} elseif (in_array($measure['measurements_type'], $basicUnitMeasurements)) {
							$measure_temp .= ' ' . $measure['measurements_unit'];
							
						} elseif ($measure['measurements_type'] == 'File size') {
							$measure_temp .= ' ' . $measure['filesize_unit'];
						
						} elseif ($measure['measurements_type'] == 'Scale') {
							$measure_temp .= ' equals ' . $measure['measurements_text_2'] . ' ' . $measure['measurements_unit_2'];
						
						} elseif ($measure['measurements_type'] == 'Weight') {
							$measure_temp .= ' ' . $measure['weight_unit'];
						
						} elseif ($measure['measurements_type'] == 'Other') {
							$measure_temp .= ' - ' . $measure['measurements_description'];
						
						}
						
						if ($measure['measurements_unit'] == 'ft' && $measure['inches_value'] != '0') {
							$measure_temp .= ', ' . $measure['inches_value'] . ' in';
						
						}
					
					} elseif ($measure['measurements_type'] == 'Duration' || $measure['measurements_type'] == 'Running time') {
					// Measurement is a duration, so uses the duration fields
					
						$measure_temp = ($measure['duration_days'] != '0') ? $measure['duration_days'] . ' days' : '';
						$measure_temp .= ($measure['duration_days'] != '0' && $measure['duration_hours'] != '0') ? ', ' : '';
						$measure_temp .= ($measure['duration_hours'] != '0') ? $measure['duration_hours'] . ' hours' : '';
						$measure_temp .= ($measure['duration_hours'] != '0' && $measure['duration_minutes']) ? ', ' : '';
						$measure_temp .= ($measure['duration_minutes'] != '0') ? $measure['duration_minutes'] . ' minutes' : '';
						$measure_temp .= ($measure['duration_minutes'] != '0' && $measure['duration_seconds'] != '0') ? ', ' : '';
						$measure_temp .= ($measure['duration_seconds'] != '0') ? $measure['duration_seconds'] . ' seconds' : '';
					
					} elseif ($measure['measurements_type'] == 'Resolution') {
					// Measurement is a screen resolution, so uses the resolution field
					
						$measure_temp = $measure['resolution_width'] . ' x ' . $measure['resolution_height'];
					
					}
					
					$workMeasure_array[] = (isset($measure_temp) && !empty($measure_temp)) ? $measure_temp . ' (' . $measure['measurements_type'] . ')' : '';
				
				}

				$result_workMeasure->free();
				
				$workMeasure_array = array_filter($workMeasure_array, 'notEmpty');
				$workMeasure_string = preg_replace('/; $/', '', implode('; ', $workMeasure_array));

				if (trim($workMeasure_string) == '') { 
					$workMeasure_string = 'None'; 
				}
			
			} else {
			// Query found no measurements for this work record
			
				$workMeasure_string = 'None';
			
			}
			
			//-----------------------------
			//		Image Measurements
			//-----------------------------
			
			$imageMeasure_array = array();

			$basicMeasurementTypes = array('Area','Bit depth','Circumference','Count','Depth','Diameter','Distance between','File size','Height','Length','Scale','Size','Weight','Width','Other');

			$basicUnitMeasurements = array('Circumference','Depth','Diameter','Distance between','Height','Length','Width');

			$sql = "SELECT * FROM $DB_NAME.measurements 
						WHERE related_images = '{$imageId}' ";

			$result_imageMeasure = db_query($mysqli, $sql);
			
			if ($result_imageMeasure->num_rows) {
			// Query found at least one measurement for this image record
			
				while ($measure = $result_imageMeasure->fetch_assoc()) {
				// Iterate through each measurement row
				
					$measure_temp = '';
					
					if (in_array($measure['measurements_type'], $basicMeasurementTypes)) {
					// Meaasurement is a basic type that uses the normal text input field
					
						$measure_temp = $measure['measurements_text'];
						
						if ($measure['measurements_type'] == 'Area') {
							$measure_temp .= ' ' . $measure['area_unit'];
							
						} elseif ($measure['measurements_type'] == 'Bit depth') {
							$measure_temp .= ' bit';
						
						} elseif (in_array($measure['measurements_type'], $basicUnitMeasurements)) {
							$measure_temp .= ' ' . $measure['measurements_unit'];
							
						} elseif ($measure['measurements_type'] == 'File size') {
							$measure_temp .= ' ' . $measure['filesize_unit'];
						
						} elseif ($measure['measurements_type'] == 'Scale') {
							$measure_temp .= ' equals ' . $measure['measurements_text_2'] . ' ' . $measure['measurements_unit_2'];
						
						} elseif ($measure['measurements_type'] == 'Weight') {
							$measure_temp .= ' ' . $measure['weight_unit'];
						
						} elseif ($measure['measurements_type'] == 'Other') {
							$measure_temp .= ' - ' . $measure['measurements_description'];
						
						}
						
						if ($measure['measurements_unit'] == 'ft' && $measure['inches_value'] != '0') {
							$measure_temp .= ', ' . $measure['inches_value'] . ' in';
						
						}
					
					} elseif ($measure['measurements_type'] == 'Duration' || $measure['measurements_type'] == 'Running time') {
					// Measurement is a duration, so uses the duration fields
					
						$measure_temp = ($measure['duration_days'] != '0') ? $measure['duration_days'] . ' days' : '';
						$measure_temp .= ($measure['duration_days'] != '0' && $measure['duration_hours'] != '0') ? ', ' : '';
						$measure_temp .= ($measure['duration_hours'] != '0') ? $measure['duration_hours'] . ' hours' : '';
						$measure_temp .= ($measure['duration_hours'] != '0' && $measure['duration_minutes']) ? ', ' : '';
						$measure_temp .= ($measure['duration_minutes'] != '0') ? $measure['duration_minutes'] . ' minutes' : '';
						$measure_temp .= ($measure['duration_minutes'] != '0' && $measure['duration_seconds'] != '0') ? ', ' : '';
						$measure_temp .= ($measure['duration_seconds'] != '0') ? $measure['duration_seconds'] . ' seconds' : '';
					
					} elseif ($measure['measurements_type'] == 'Resolution') {
					// Measurement is a screen resolution, so uses the resolution field
					
						$measure_temp = $measure['resolution_width'] . ' x ' . $measure['resolution_height'];
					
					}
					
					$imageMeasure_array[] = (isset($measure_temp) && !empty($measure_temp)) ? $measure_temp . ' (' . $measure['measurements_type'] . ')' : '';
				
				}

				$result_imageMeasure->free();
				
				$imageMeasure_array = array_filter($imageMeasure_array, 'notEmpty');
				$imageMeasure_string = preg_replace('/; $/', '', implode('; ', $imageMeasure_array));

				if (trim($imageMeasure_string) == '') { 
					$imageMeasure_string = 'None'; 
				}
			
			} else {
			// Query found no measurements for this image record
			
				$imageMeasure_string = 'None';
			
			}
		}
		elseif ($field == 'location')
		{	
			//----------------------
			//		Location
			//----------------------
			
			$location_array = array();

			$sql = "SELECT * FROM $DB_NAME.location 
						WHERE related_images = '{$imageId}' ";
			
			// Select locations from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' ";
			}
			
			$result_location = db_query($mysqli, $sql);
			
			if ($result_location->num_rows > 0) {
			// Query found at least one location for this image or work record
			
				$super_location_array = array();
				
				while ($location = $result_location->fetch_assoc()) {
				// Iterate through each location row
				
					$location_array[] = (!empty($location['location_text'])) 
						? $location['location_text'] . ' (' . $location['location_type'] . ')' 
						: '';
					
					if (!empty($location['location_getty_id']) && substr($location['location_getty_id'], 0, 3) != 'rep') {
					// This location row has a Getty id (that is NOT a local repository id)
					
						$sql = "SELECT english_pref_term, nonpref_term
									FROM $DB_NAME.getty_tgn
									WHERE getty_id = '{$location['location_getty_id']}' ";

						$result_altLocations = db_query($mysqli, $sql);
						
						while ($nonprefLocation = $result_altLocations->fetch_assoc()) {
						
							$nonprefLocation_array = explode(' || ', $nonprefLocation['nonpref_term']);

							if (trim($nonprefLocation['english_pref_term']) != '') {
								$nonprefLocation_array[] = $nonprefLocation['english_pref_term'];
							}
						
						}
						
						$nonprefLocation_array = array_filter($nonprefLocation_array, 'notEmpty');
						$super_location_array = array_merge($super_location_array, $nonprefLocation_array);
					
					}
					
					$location_array = array_filter($location_array, 'notEmpty');
					$location_string = preg_replace('/; $/', '', implode('; ', $location_array));

					if (trim($location_string) == '') { 
						$location_string = 'None'; 
					}
					
					$super_location_string = preg_replace('/; $/', '', implode('; ', $super_location_array));
				
				}

				$result_location->free();
			
			} else {
			// Query found no locations for this image or work record
			
				$location_string = 'None';
			
			}
		}
		elseif ($field == 'specificLocation')
		{	

			//----------------------
			//		Specific Location
			//----------------------
			
			$specific_location_array = array();

			$sql = "SELECT * FROM $DB_NAME.specific_location 
						WHERE related_images = '{$imageId}' ";
			
			// Select locations from work record as well, if this image record has an associated work
			if ($workId != 'None') 
			{ 
				$sql.= " || related_works = '{$workId}' ";
			}
			
			$result_specific_location = db_query($mysqli, $sql);
			
			if ($result_specific_location->num_rows > 0) 
			{
			// Query found at least one location for this image or work record
			
				$super_specific_location_array = array();
				
				while ($specific_location = $result_specific_location->fetch_assoc())
				{
				// Iterate through each location row
				
					$specific_location_array[] = (!empty($specific_location['specific_location_address'])) 
						? $specific_location['specific_location_address'].', '.$specific_location['specific_location_zip'].' ('.$specific_location['specific_location_type'].')' 
						: '';
					
					$specific_location_array[] = (!empty($specific_location['specific_location_lat'])) 
						? $specific_location['specific_location_lat'].', '.$specific_location['specific_location_long'].' ('.$specific_location['specific_location_type'].')' 
						: '';

					$specific_location_array[] = (!empty($specific_location['specific_location_note'])) 
						? $specific_location['specific_location_note'].' ('.$specific_location['specific_location_type'].')' 
						: '';				
				}
					
				$specific_location_array = array_filter($specific_location_array, 'notEmpty');
				$specific_location_string = preg_replace('/; $/', '', implode('; ', $specific_location_array));

				if (trim($specific_location_string) == '') 
				{ 
					$specific_location_string = 'None'; 
				}
				
				$super_specific_location_string = preg_replace('/; $/', '', implode('; ', $super_specific_location_array));
			
				$result_specific_location->free();
			}

		 	else 
			{
			// Query found no locations for this image or work record
				$specific_location_string = 'None';
			}
		}
		elseif ($field == 'relation')
		{	
			
			//----------------------------
			//		Relation
			//----------------------------
		
			$relation_array = array();

			$sql = "SELECT * FROM $DB_NAME.relation 
						WHERE related_works = '{$workId}' ";

			// Select cultures from work record as well, if this image record has an associated work
			
			$result_relation = db_query($mysqli, $sql);
			
			if ($result_relation->num_rows > 0) 
			{
			// Query found at least one culture for this image or work record
			
				$super_relation_array = array();
				
				while ($relation = $result_relation->fetch_assoc()) 
				{
				// Iterate through each relation row	
					
					if (!empty($relation['relation_id'])) 
					{

						$sql ="SELECT title_text 
							FROM $DB_NAME.title
							WHERE related_works = '{$relation['relation_id']}'";

						$resultRelationTitle = $mysqli->query($sql);   

                  while ($row = $resultRelationTitle->fetch_assoc())
                  {
                     $relatedTitle = $row['title_text'];

								$sql ="SELECT agent_text 
								FROM $DB_NAME.agent
								WHERE related_works = '{$relation['relation_id']}'";

								$resultRelationAgent = $mysqli->query($sql);   

                  		while ($row = $resultRelationAgent->fetch_assoc())
                  		{
                     		$relatedAgent = $row['agent_text'];

                    			if (!empty($relation['relation_type']) && !empty($relatedTitle))
		                    {    
										$relation_array[] = (!empty($relation['relation_type'])) 
										? $relation['relation_type'].' '.$relatedTitle.' ('.$relatedAgent.')' 
										: '';
									}	
								
								}

								$relation_array = array_filter($relation_array, 'notEmpty');
								$relation_string = preg_replace('/; $/', '', implode('; ', $relation_array));

								if (trim($relation_string) == '') 
								{ 
									$relation_string = 'None'; 
								}
								
								$super_relation_string = preg_replace('/; $/', '', implode('; ', $super_relation_array));
						}
					}
				}

				$result_relation->free();	
			}	 	
			else 
			{
			// Query found no cultural contexts for this image or work record
			$relation_string = 'None';		
			}		
				
		}
		elseif ($field == 'culturalContext')
		{	
			
			//----------------------------
			//		Cultural Context
			//----------------------------
			
			$culture_array = array();

			$sql = "SELECT * FROM $DB_NAME.culture 
						WHERE related_images = '{$imageId}' ";

			// Select cultures from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_culture = db_query($mysqli, $sql);
			
			if ($result_culture->num_rows > 0) {
			// Query found at least one culture for this image or work record
			
				$super_culture_array = array();
				
				while ($culture = $result_culture->fetch_assoc()) {
				// Iterate through each culture row
				
					$culture_array[] = (!empty($culture['culture_text'])) 
						? $culture['culture_text'] 
						: '';
					
					if (!empty($culture['culture_getty_id'])) {
					// This culture row has a Getty id
					
						$sql = "SELECT english_pref_term, nonpref_term_text
									FROM $DB_NAME.getty_aat
									WHERE getty_id = '{$culture['culture_getty_id']}' ";

						$result_altCultures = db_query($mysqli, $sql);
						
						while ($nonprefCulture = $result_altCultures->fetch_assoc()) {
						
							$nonprefCulture_array = explode(' || ', $nonprefCulture['nonpref_term_text']);

							if (trim($nonprefCulture['english_pref_term']) != '') { 
								$nonprefCulture_array[] = $nonprefCulture['english_pref_term']; 
							}
						
						}
						
						$nonprefCulture_array = array_filter($nonprefCulture_array, 'notEmpty');
						$super_culture_array = array_merge($super_culture_array, $nonprefCulture_array);
					
					}
					
					$culture_array = array_filter($culture_array, 'notEmpty');
					$culture_string = preg_replace('/; $/', '', implode('; ', $culture_array));

					if (trim($culture_string) == '') { 
						$culture_string = 'None'; 
					}
					
					$super_culture_string = preg_replace('/; $/', '', implode('; ', $super_culture_array));
				
				}

				$result_culture->free();
			
			} else {
			// Query found no cultural contexts for this image or work record
			
				$culture_string = 'None';
			
			}
		}
		elseif ($field == 'stylePeriod')
		{	
			//---------------------------
			//		Style Period
			//---------------------------
			
			$style_period_array = array();

			$sql = "SELECT * FROM $DB_NAME.style_period 
						WHERE related_images = '{$imageId}' ";

			// Select styleperiods from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_style_period = db_query($mysqli, $sql);
			
			if ($result_style_period->num_rows > 0) {
			// Query found at least one styleperiod for this image or work record
			
				$super_style_period_array = array();
				
				while ($style_period = $result_style_period->fetch_assoc()) {
				// Iterate through each styleperiod row
				
					$style_period_array[] = (!empty($style_period['style_period_text'])) 
						? $style_period['style_period_text'] 
						: '';
					
					if (!empty($style_period['style_period_getty_id'])) {
					// This styleperiod row has a Getty id
					
						$sql = "SELECT english_pref_term, nonpref_term_text
									FROM $DB_NAME.getty_aat
									WHERE getty_id = '{$style_period['style_period_getty_id']}' ";

						$result_altStyle_periods = db_query($mysqli, $sql);
						
						while ($nonprefStyle_period = $result_altStyle_periods->fetch_assoc()) {
						
							$nonprefStyle_period_array = explode(' || ', $nonprefStyle_period['nonpref_term_text']);

							if (trim($nonprefStyle_period['english_pref_term']) != '') { 
								$nonprefStyleperiod_array[] = $nonprefStyle_period['english_pref_term']; 
							}
						
						}
						
						$nonprefStyle_period_array = array_filter($nonprefStyle_period_array, 'notEmpty');
						$super_style_period_array = array_merge($super_style_period_array, $nonprefStyle_period_array);
					
					}
					
					$style_period_array = array_filter($style_period_array, 'notEmpty');
					$style_period_string = preg_replace('/; $/', '', implode('; ', $style_period_array));

					if (trim($style_period_string) == '') { 
						$style_period_string = 'None'; 
					}
					
					$super_style_period_string = preg_replace('/; $/', '', implode('; ', $super_style_period_array));
				
				}

				$result_style_period->free();
			
			} else {
			// Query found no styleperiods for this image or work record
			
				$style_period_string = 'None';
			
			}
		}
		elseif ($field == 'description')
		{	
			//----------------------------
			//		Work Description
			//----------------------------
			
			$sql = "SELECT description FROM $DB_NAME.work WHERE id = '{$workId}' ";

			$result_workDescription = db_query($mysqli, $sql);

			while ($row = $result_workDescription->fetch_assoc()) {
				$workDescription_string = preg_replace('/\s+/', ' ',str_replace("\n", '', trim($row['description'])));
			}

			if ($workDescription_string == '') { 
				$workDescription_string = 'No description'; 
			}
			
			//----------------------------
			//		Image Description
			//----------------------------
			
			// NOTE: Image description defined above when associated work was queried

			$imageDescription_string = preg_replace('/\s+/', ' ',str_replace("\n", '', trim($imageDescription)));

			if ($imageDescription_string == '') {
				$imageDescription_string = 'No description'; 
			}
		}
		elseif ($field == 'source')
		{	
			//----------------------
			//		Source
			//----------------------

			$source_array = array();

			$sql = "SELECT * FROM $DB_NAME.source 
						WHERE related_images = '{$imageId}' ";

			// Select sources from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_source = db_query($mysqli, $sql);
			
			if ($result_source->num_rows > 0) {
			// Query found at least one source for this image or work record
			
				while ($source = $result_source->fetch_assoc()) {
				// Iterate through each source row
				
					$source_temp = (!empty($source['source_name_text'])) 
						? $source['source_name_text'] 
						: '';

					$source_temp .= (!empty($source['source_name_type'])) 
						? ' (' . $source['source_name_type'] . ')' 
						: '';

					$source_temp .= (!empty($source['source_name_text']) && !empty($source['source_text'])) 
						? ', ' 
						: '';
					
					if (setEqual($source['source_type'], 'ISBN')) {

						// Wrap ISBN in hyperlink to Amazon's product page
						$source_temp .= (!empty($source['source_text'])) 
							? '<a href="http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Dstripbooks&field-keywords=' . $source['source_text'] . '">' . $source['source_text'] . '</a>' 
							: '';

					} else {

						$source_temp .= (!empty($source['source_text'])) 
							? $source['source_text'] 
							: '';
					}
					
					$source_temp .= (!empty($source['source_type'])) 
						? ' (' . $source['source_type'] . ')' 
						: '';
					
					$source_array[] = $source_temp;
				
				}

				$result_source->free();
				
				$source_array = array_filter($source_array, 'notEmpty');
				$source_string = preg_replace('/; $/', '', implode('; ', $source_array));
				if (trim($source_string) == '') { $source_string = 'None'; }
			
			} else {
			// Query found no sources for this image or work record
			
				$source_string = 'None';
			
			}
		}
		elseif ($field == 'subject')
		{	
			//----------------------
			//		Subjects
			//----------------------

			$subject_array = array();

			$sql = "SELECT * FROM $DB_NAME.subject 
						WHERE related_images = '{$imageId}' ";

			// Select subjects from work record as well, if this image record has an associated work
			if ($workId != 'None') { 
				$sql.= " || related_works = '{$workId}' "; 
			}
			
			$result_subject = db_query($mysqli, $sql);
			
			if ($result_subject->num_rows > 0) {
			// Query found at least one subject for this image or work record
			
				while ($subject = $result_subject->fetch_assoc()) {
				// Iterate through each source row
				
					$subject_array[] = $subject['subject_text'];
					
					$sql = "SELECT english_pref_term, nonpref_term_text
								FROM $DB_NAME.getty_aat
								WHERE getty_id = '{$subject['subject_getty_id']}' ";

					$result_nonprefSubject = db_query($mysqli, $sql);
					
					while ($nonprefSubject = $result_nonprefSubject->fetch_assoc()) {
						
						$nonprefSubject_array = explode(' || ', $nonprefSubject['nonpref_term_text']);

						if (trim($nonprefSubject['english_pref_term']) != '') { 
							$nonprefSubject_array[] = $nonprefSubject['english_pref_term']; 
						}
						
						foreach ($nonprefSubject_array as $term) {
							$subject_array[] = $term;
						}
					
					}
				
				}

				$result_subject->free();
				
				$subject_array = array_filter($subject_array, 'notEmpty');
				$subject_string = preg_replace('/; $/', '', implode('; ', $subject_array));
			
			} else {
			// Query found no sources for this image or work record
			
				$subject_string = '';
			
			}
		}		
	}	
		//-------------------------
		//		Lecture Tags
		//-------------------------

		$lectureTag_array = array();

		$sql = "SELECT * FROM $DB_NAME.lecture_tag 
					WHERE related_image = '{$imageId}' ";

		$result_lectureTag = db_query($mysqli, $sql);
		
		if ($result_lectureTag->num_rows > 0)
		{ // Query found at least one lecture tag for this image record
		
			while ($tag = $result_lectureTag->fetch_assoc())
			{ // Iterate through each lecture tag row
			
				$lectureTag_array[] = $tag['text'];
			
			}

			$result_lectureTag->free();
			
			$lectureTag_array = array_filter($lectureTag_array, 'notEmpty');
			$lectureTag_string = preg_replace('/; $/', '', implode('; ', $lectureTag_array));

			if (trim($lectureTag_string) == '') { 
				$lectureTag_string = 'None';
			}
		
		}
		else
		{ // Query found no lecture tags for this image record
		
			$lectureTag_string = 'None';
		
		}
		
		//-------------------------
		//		Order
		//-------------------------

		$sql = "SELECT order_id FROM $DB_NAME.image 
					WHERE id = '{$imageId}' ";

		$result_order = db_query($mysqli, $sql);
		
		if ($result_order->num_rows > 0)
		{ // Query found at least one order for this image record
		
			while ($image = $result_order->fetch_assoc())
			{ // Iterate through each lecture tag row
			
				$order_string = create_four_digits($image['order_id']);
			
			}

			$result_order->free();
					
		}
		else
		{
		// Query found no lecture tags for this image record
		
			$order_string = 'None ( !! CONTACT ADMIN !! )';
		
		}
	
	// Write each row of the csv array
	$csvArray[$i] = array();

	
		if (!empty($legacyId))  
		{	
			$csvArray[$i]['Identifier'] = $legacyId;
		}
		
		if (!empty($legacyId) && !empty($fileFormat)) 
		{		
			$csvArray[$i]['resource'] = $legacyId . $fileFormat;
		}

		if (!empty($workTitle_string))
		{
			$csvArray[$i]['vra.title'] = $workTitle_string;
		}

		if (!empty($imageTitle_string))
		{
			$csvArray[$i]['vra.imagetitle'] = $imageTitle_string;
		}

		if (!empty($agent_string))
		{	
		$csvArray[$i]['vra.agent'] =  $agent_string;
		}

		if (!empty($super_nonprefAgent_string))
		{	
		$csvArray[$i]['agentALT'] = $super_nonprefAgent_string;
		}

		if (!empty($date_string))
		{			
			$csvArray[$i]['vra.date'] = $date_string;
		}

		if (!empty($technique_string))
		{			
			$csvArray[$i]['vra.technique'] = $technique_string;
		}

		if (!empty($super_technique_string))
		{	
			$csvArray[$i]['techniqueALT'] = $super_technique_string;
		}

		if (!empty($worktype_string))
		{	
			$csvArray[$i]['vra.worktype'] = $worktype_string;
		}

		if (!empty($super_worktype_string))
		{	
			$csvArray[$i]['worktypeALT'] = $super_worktype_string;
		}

		if (!empty($material_string))
		{	
			$csvArray[$i]['vra.material'] = $material_string;
		}

		if (!empty($super_material_string))
		{			
			$csvArray[$i]['materialALT'] = $super_material_string;
		}

		if (!empty($workMeasure_string))
		{ 	
			$csvArray[$i]['vra.measurementsWORK'] = $workMeasure_string;
		}

		if (!empty($imageMeasure_string))
		{	
			$csvArray[$i]['vra.measurementsIMAGE'] = $imageMeasure_string;
		}

		if (!empty($location_string))
		{	
			$csvArray[$i]['vra.location'] = $location_string;
		}

		if (!empty($super_location_string))
		{
			$csvArray[$i]['locationALT'] = $super_location_string;		
		}	

		if (!empty($specific_location_string))
		{	
			$csvArray[$i]['specificLocation'] = $specific_location_string;
		}

		if (!empty($super_specific_location_string))
		{
			$csvArray[$i]['specificLocationALT'] = $super_specific_location_string;		
		}	
		
		if (!empty($relation_string))
		{
			$csvArray[$i]['vra.relation'] = $relation_string;	
		}

		if (!empty($super_relation_string))
		{
			$csvArray[$i]['relationALT'] = $super_relation_string;
		}

		if (!empty($culture_string))
		{
			$csvArray[$i]['vra.culturalContext'] = $culture_string;	
		}			
		
		if (!empty($super_culture_string))
		{	
			$csvArray[$i]['culturalContextALT'] = $super_culture_string;
		}

		if (!empty($style_period_string))
		{
			$csvArray[$i]['vra.stylePeriod'] = $style_period_string;	
		}			
		
		if (!empty($super_style_period_string))
		{	
			$csvArray[$i]['stylePeriodALT'] = $super_style_period_string;
		}

		if (!empty($workDescription_string))
		{
			$csvArray[$i]['vra.descriptionWORK'] = $workDescription_string;	
		}			
		
		if (!empty($imageDescription_string))
		{	
			$csvArray[$i]['vra.descriptionIMAGE'] = $imageDescription_string;
		}
		
		if (!empty($source_string))
		{	
			$csvArray[$i]['vra.source'] = $source_string;
		}
		
		if (!empty($subject_string))
		{	
			$csvArray[$i]['tags.tags'] = $subject_string;
		}

		if (!empty($lectureTag_string))
		{	
			$csvArray[$i]['vu.courselecture'] = $lectureTag_string;
		}
		
		if (!empty($order_string))
		{	
			$csvArray[$i]['order'] = $order_string;
		}

	$i++;	
}

function encode_items($csvArray)
{
    foreach($csvArray as $key => $value)
    {
        if(is_array($value))
        {
            $csvArray[$key] = encode_items($value);
        }

        else
        {
            $csvArray[$key] = mb_convert_encoding($value, 'UTF-16LE', 'UTF-8');
        }
    }

    return $csvArray;
}

header("Content-type: text/csv; ");
header("Content-Disposition: attachment; filename={$filename}");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
header("Expires: 0");

echo array2csv($csvArray); // Defined in _php/_config/functions.php

?>
<?php
//---------------------------------------------------------
//		Update the images' "last_exported" timestamp
//---------------------------------------------------------

$timestamp = date('Y-m-d H:i:s');
$sql = "UPDATE $DB_NAME.image
			SET last_exported = '{$timestamp}',
				flagged_for_export = '0'
			WHERE {$updateThese} ";

$result_lastExported = db_query($mysqli, $sql);

?>
