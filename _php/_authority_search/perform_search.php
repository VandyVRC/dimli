<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

// Determine on which field the search was performed
// $fieldName = $_POST['json']['fieldName'];
$fieldName = $_POST['fieldName'];
$lastDigit = substr($fieldName, -1);
$firstChar = substr($fieldName, 0, 1);

// $fieldVal = $_POST['json']['fieldVal'];
$fieldVal = $_POST['fieldVal'];

// Determine where the user is coming from
// Used below to add a GET variable to the form action url

if ($firstChar == 'W') { // Coming from Work record
	$workOrImage = 'work';
}
elseif ($firstChar == 'I') { // Coming from Image record
	$workOrImage = 'image';
}
elseif ($firstChar == 'N') { // Coming from "Create New Work"
	$workOrImage = 'createNewWork';
}

reset($_POST);

if (!empty($fieldVal)) {

	/*#################
	  ##             ##
	  ##    AGENT    ##
	  ##             ##
	  #################*/

	if (strstr($fieldName, 'agent')) {

		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$namesArray = explode(' ', $fieldVal);
		// Explode the string into an array
		
		$sql = "SELECT * 
					FROM $DB_NAME.getty_ulan 
					WHERE id != '0' ";
		
		if (!empty($namesArray)) {
		// An agent type was specified
		
			foreach ($namesArray as $name):
			
				$sql.= " AND (english_pref_term REGEXP '{$name}' OR pref_term REGEXP '{$name}' OR nonpref_term REGEXP '{$name}') ";
				
			endforeach;
			
		}
		
		$sql.= (!empty($type)) 
					? " AND record_type REGEXP '{$type}' " 
					: "" ;
				
		$sql.= " ORDER BY popularity DESC, pref_term ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty ULAN';
			include('agent_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
		
	}

	/*####################
	  ##                ##
	  ##    MATERIAL    ##
	  ##                ##
	  ####################*/

	if (strstr($fieldName, 'material')) {
		
		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$materialsArray = explode(' ', $fieldVal);
		// Explode the string into an array

		// Build SQL query
		$sql = "SELECT * 
					FROM $DB_NAME.getty_aat 
					WHERE ( hierarchy REGEXP 'Materials Facet' 
						OR hierarchy REGEXP 'Components' 
						OR hierarchy REGEXP 'image-making equipment' ) ";
		
		if (!empty($materialsArray)) {
		
			foreach ($materialsArray as $material) {
			
				$sql.= " AND (english_pref_term REGEXP '{$material}' OR pref_term_text REGEXP '{$material}' OR nonpref_term_text REGEXP '{$material}' OR pref_term_qualifier REGEXP '{$material}') ";
				
			}
			
		}
		
		$sql.= " AND record_type != 'Guide term' ";
		$sql.= " ORDER BY popularity DESC, pref_term_text ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty AAT';
			include('material_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
		
	}

	/*#####################
	  ##                 ##
	  ##    TECHNIQUE    ##
	  ##                 ##
	  #####################*/

	if (strstr($fieldName, 'technique')) {

		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$techniqueArray = explode(' ', $fieldVal);
		// Explode the string into an array

		// Build SQL query
		$sql = " SELECT * 
					FROM $DB_NAME.getty_aat 
					WHERE hierarchy REGEXP 'Processes and Techniques' ";
		
		if (!empty($techniqueArray)) {
		
			foreach ($techniqueArray as $technique) {
			
				// $technique = preg_replace('/\([^)]+\)/', '', $technique);
				$sql.= " AND (english_pref_term REGEXP '{$technique}' OR pref_term_text REGEXP '{$technique}' OR nonpref_term_text REGEXP '{$technique}' OR pref_term_qualifier REGEXP '{$technique}') ";
				
			}
			
		}
		
		$sql.= " AND record_type != 'Guide term' ";
		$sql.= " ORDER BY popularity DESC, pref_term_text ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty AAT';
			include('technique_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
		
	}

	/*#####################
	  ##                 ##
	  ##    WORK TYPE    ##
	  ##                 ##
	  #####################*/

	
	if (strstr($fieldName, 'workType')) {
		
		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$workTypeArray = explode(' ', $fieldVal);
		// Explode the string into an array

		// Build SQL query
		$sql = "SELECT * 
					FROM $DB_NAME.getty_aat 
					WHERE ( hierarchy REGEXP 'Visual Works' 
						OR  hierarchy REGEXP 'Built Environment' 
						OR hierarchy REGEXP 'Objects Facet' ) ";
		
		if (!empty($workTypeArray)) {
		
			foreach ($workTypeArray as $workType) {
			
				// $workType = preg_replace('/\([^)]+\)/', '', $workType);
				$sql.= " AND (english_pref_term REGEXP '{$workType}' OR pref_term_text REGEXP '{$workType}' OR nonpref_term_text REGEXP '{$workType}' OR pref_term_qualifier REGEXP '{$workType}') ";
				
			}
			
		}
		
		$sql.= " AND record_type != 'Guide term' ";
		$sql.= " ORDER BY popularity DESC, pref_term_text ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty AAT';
			include('workType_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
	}

	/*###################
	  ##               ##
	  ##    CULTURE    ##
	  ##               ##
	  ###################*/

	if (strstr($fieldName, 'culturalContext')) {
		
		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$cultureArray = explode(' ', $fieldVal);
		// Explode the string into an array

		// Build SQL query
		$sql = " SELECT * 
					FROM $DB_NAME.getty_aat 
					WHERE ( hierarchy REGEXP 'styles and periods by general era'
						OR hierarchy REGEXP 'styles and periods by region' ) ";
		
		if (!empty($cultureArray)) {
		
			foreach ($cultureArray as $culture) {
			
				$culture = preg_replace('/\([^)]+\)/', '', $culture);
				$sql.= " AND (english_pref_term REGEXP '{$culture}' OR pref_term_text REGEXP '{$culture}' OR nonpref_term_text REGEXP '{$culture}' OR pref_term_qualifier REGEXP '{$culture}') ";
				
			}
			
		}
		
		$sql.= " AND record_type != 'Guide term' ";
		$sql.= " ORDER BY popularity DESC, pref_term_text ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty AAT';
			include('culturalContext_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
		
	}

	/*########################
	  ##                    ##
	  ##    STYLE PERIOD    ##
	  ##                    ##
	  ########################*/

	if (strstr($fieldName, 'style')) {
		
		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$styleArray = explode(' ', $fieldVal);
		// Explode the string into an array

		// Build SQL query
		$sql = " SELECT * 
					FROM $DB_NAME.getty_aat 
					WHERE ( hierarchy REGEXP 'styles and periods by region'
						OR hierarchy REGEXP 'generic styles and periods'
						OR hierarchy REGEXP 'styles and periods by general era' ) ";
		
		if (!empty($styleArray)) {
		
			foreach ($styleArray as $style) {
			
				$style = preg_replace('/\([^)]+\)/', '', $style);
				$sql.= " AND (english_pref_term REGEXP '{$style}' OR pref_term_text REGEXP '{$style}' OR nonpref_term_text REGEXP '{$style}' OR pref_term_qualifier REGEXP '{$style}') ";
				
			}
			
		}
		
		$sql.= " AND record_type != 'Guide term' ";
		$sql.= " ORDER BY popularity DESC, pref_term_text ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty AAT';
			include('stylePeriod_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
		
	}

	/*####################
	  ##                ##
	  ##    LOCATION    ##
	  ##                ##
	  ####################*/

	if (strstr($fieldName, 'location')) {

		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$locationArray = explode(' ', $fieldVal);
		// Explode the string into an array

		//---------------------------
		//		QUERY GETTY TGN
		//---------------------------
		
		$sql = "SELECT * 
					FROM $DB_NAME.getty_tgn 
					WHERE ( hierarchy != 'Extraterrestrial Places' ) ";
		
		if (!empty($locationArray)) {
		
			foreach ($locationArray as $location) { 
			
				$sql.= " AND (english_pref_term REGEXP '{$location}' OR getty_pref_term REGEXP '{$location}' OR nonpref_term REGEXP '{$location}' OR pref_place_type REGEXP '{$location}') ";
				
			}
			
		} 

		reset($locationArray);
		
		$sql.= " ORDER BY popularity DESC, getty_pref_term ";
		
		$result = $mysqli->query($sql);
		
		$resultCount_tgn = $result->num_rows;
		
		//---------------------------------
		//		QUERY REPOSITORY LIST
		//---------------------------------
		
		$sql = "SELECT * 
					FROM $DB_NAME.repository 
					WHERE (id > 0) ";
		
		foreach ($locationArray as $location) {

			$location = preg_replace('/\([^)]+\)/', '', $location);
			$sql .= " AND (museum REGEXP '{$location}' OR address REGEXP '{$location}' OR city REGEXP '{$location}' OR state REGEXP '{$location}' OR zip REGEXP '{$location}' OR region REGEXP '{$location}' OR country REGEXP '{$location}' OR phone REGEXP '{$location}' OR website REGEXP '{$location}') ";

		}
		
		$sql.= " ORDER BY popularity DESC, museum ";
		
		$result_repository = $mysqli->query($sql);
		
		$resultCount_repository = $result_repository->num_rows;

		$message = '<a href="#authorityResults_location_repository">';	
		$message .= $resultCount_repository.' ';
		$message .= ($resultCount_repository != 1) ? 'repositories' : 'repository';	
		$message .= '</a>';
		include('location_results.php');
}

	/*####################
	  ##                ##
	  ##   Built Works  ##
	  ##                ##
	  ####################*/

	if (strstr($fieldName, 'builtWork')) {

		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$builtWorkArray = explode(' ', $fieldVal);
		// Explode the string into an array

		//---------------------------
		//		QUERY Built Works
		//---------------------------

		$sql = "SELECT * 
					FROM $DB_NAME.title 
					WHERE ( related_works != '' ) ";

		foreach ($builtWorkArray as $builtWork) {
		
			$sql .= " AND ( title_text REGEXP '{$builtWork}' ) ";
		
		}

		$sql.= " ORDER BY title_text ASC ";
		$result_builtWorkTitle = $mysqli->query($sql);

		$builtWorkIds = array();

		while ($row = $result_builtWorkTitle->fetch_assoc()) {
		
			// Add each result to an array of ids for works with titles that match the search
			$builtWorkIds[] = $row['related_works'];
		
		}

			$builtWorkIds_filteredOnce = array();

		// Initilize array of work types that can appropriately be called "built works"
		$acceptableWorkTypes = array(
			'buildings (structures)',
			'churches (buildings)',
			'cathedrals (buildings)',
			'temples (buildings)',
			'villas',
			'hospitals (buildings for pilgrims)',
			'funerary buildings',
			'mosques (buildings)',
			'art museums (buildings)',
			'art galleries (buildings)',
			'hippodromes (Greek sports buildings)',
			'international museums (buildings)',
			'landmark buildings',
			'monastic churches (buildings)',
			'museums (buildings)',
			'national museums (buildings)',
			'pilgrimage churches (buildings)',
			'amphitheaters (built works)',
			'theaters (buildings)',
			'caves',
			'cave architecture',
			'cave churches',
			'cave dwellings',
			'cave temples',
			'ducal palaces',
			'tombs'
			);


		$sql = "SELECT  pref_term_text
					FROM $DB_NAME.getty_aat 
					WHERE ( hierarchy REGEXP 'Built Environment' ) ";

		$result_acceptableWorkTypes = $mysqli->query($sql);


			while ($row = $result_acceptableWorkTypes->fetch_assoc()) {

				$acceptableWorkTypes[] = $row['pref_term_text'];
			}	

		
			// For each work id returned so far
		foreach ($builtWorkIds as $id):
		
			// Find its "work type" attributes
			$sql = " SELECT * FROM $DB_NAME.work_type WHERE related_works = '{$id}' ";
			$result_workTypeText = $mysqli->query($sql);

			// For each "work type"
			while ($row = $result_workTypeText->fetch_assoc()):
			
				// If this work type is appropriate
				if (in_array($row['work_type_text'], $acceptableWorkTypes)) {

					// Add the work id to the filtered array
					$builtWorkIds_filteredOnce[] = $row['related_works'];

				}	

			endwhile;

		endforeach;

		// Eliminate duplicate work ids
		$builtWorkIds_filteredOnce = array_unique($builtWorkIds_filteredOnce);

		// Reset array keys
		$builtWorkIds_filteredOnce = array_values($builtWorkIds_filteredOnce);

		
		$message = count($builtWorkIds_filteredOnce);
		$message .= (count($builtWorkIds_filteredOnce) != 1) ? ' built works' : ' built work';

			include('builtWork_results.php');

	}

	/*##################
	  ##              ##
	  ##   SUBJECT    ##
	  ##              ##
	  ##################*/

	if (strstr($fieldName, 'subject')) {
		
		$fieldVal = preg_replace("/[^A-Za-z0-9\s]/"," ", $fieldVal);
		// Remove all non-alphanumeric characters from the input string
		
		$fieldVal = trim(preg_replace("/ +/"," ", $fieldVal));
		// Limit the space between words to one single space
		
		$subjectArray = explode(' ', $fieldVal);
		// Explode the string into an array

		// Build SQL query
		$sql = " SELECT * 
					FROM $DB_NAME.getty_aat 
					WHERE ( id > 1 ) ";
		
		if (!empty($subjectArray)) {
		
			foreach ($subjectArray as $subject) {
			
				$subject = preg_replace('/\([^)]+\)/', '', $subject);
				$sql.= " AND ( english_pref_term REGEXP '{$subject}' OR pref_term_text REGEXP '{$subject}' OR nonpref_term_text REGEXP '{$subject}' OR pref_term_qualifier REGEXP '{$subject}' ) ";
				
			}
			
		}
		
		$sql.= " AND record_type != 'Guide term' ";
		$sql.= " ORDER BY popularity DESC, pref_term_text ";

		if ($result = $mysqli->query($sql)) {

			$resultCount = $result->num_rows;
			$message = $resultCount . ' results from the Getty AAT';
			include('subject_results.php');

		} else {

			echo "SQL error: ".$mysqli->errno." ".$mysqli->error;

		}
	}
}

?>

