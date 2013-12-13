<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__').$urlpatch);}

require_once(MAIN_DIR.'/../../_php/_config/functions.php');


//-----------------
//	 Query Updates
//-----------------

$sql = "SELECT * 
			FROM $DB_NAME.image 
			WHERE id = '{$_SESSION['imageNum']}' ";

$result_imageUpdates = db_query($mysqli, $sql);

while ($image = $result_imageUpdates->fetch_assoc()) {

	$last_update = 	$image['last_update'];
	$last_update_by = $image['last_update_by'];
	$order_id = 		$image['order_id'];
	$last_exported = 	$image['last_exported'];

}

$sql = "SELECT date_created, 
				created_by 
			FROM $DB_NAME.order 
			WHERE id = '{$order_id}' ";

$result_orderInfo = db_query($mysqli, $sql);

while ($order = $result_orderInfo->fetch_assoc()) {

	$date_created = 	$order['date_created'];
	$created_by = 		$order['created_by'];

}

//---------------
//	 Query Titles
//---------------

$sql = "SELECT * 
			FROM $DB_NAME.title 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageTitles = db_query($mysqli, $sql);

$imageTitles = array();

while ($title = $result_imageTitles->fetch_assoc()) {

	$title_text = $title['title_text'];
	$title_type = $title['title_type'];
	
	$display_temp = '';
	$display_temp.= ($title_text != '') 
		? $title_text 
		: '';

	$display_temp.= ($title_type != '') 
		? ' (' . $title_type . ')' 
		: '';

	$imageTitles[] = array($display_temp=>$title['display']);

}

//---------------
//	 Query Agents
//---------------

$sql = "SELECT * 
			FROM $DB_NAME.agent 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageAgents = db_query($mysqli, $sql);

$imageAgents = array();

while ($agent = $result_imageAgents->fetch_assoc()) {

	$agent_attr = 	$agent['agent_attribution'];
	$agent_text = 	$agent['agent_text'];
	$agent_type = 	$agent['agent_type'];
	$agent_role = 	$agent['agent_role'];
	$agent_AID = 	$agent['agent_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($agent_AID == '') 
			? '<span class="mediumWeight purple">[UD]</span> ' 
			: '';
	$display_temp.= ($agent_attr != 'None') 
		? $agent_attr . ' ' 
		: '';

	$display_temp.= (!empty($agent_text)) 
		? $agent_text 
		: '';

	$display_temp.= (!empty($agent_role)) 
		? ' (' . $agent_role . ')' 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageAgents[] = array($display_temp=>$agent['display']);

}

//---------------
//	 Query Dates
//---------------

$sql = "SELECT * 
			FROM $DB_NAME.date 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageDates = db_query($mysqli, $sql);

$imageDates = array();

while ($date = $result_imageDates->fetch_assoc()) {

	$display_temp = '';

	$display_temp.= ($date['date_circa'] == 1) 
		? 'ca. ' 
		: '';

	$display_temp.= (!empty($date['date_text'])) 
		? $date['date_text'] 
		: '';

	$display_temp.= ($date['date_range'] == 1 && $date['date_era'] != $date['enddate_era'])
			? ' '.$date['date_era']
			: '';

	$display_temp.= ($date['date_range'] == 1) 
		? ' - ' 
		: ' '.$date['date_era'];

	$display_temp.= ($date['date_range'] == 1 && !empty($date['enddate_text'])) 
		? $date['enddate_text'].' '.$date['enddate_era'] 
		: '';

	$display_temp.= ($date['date_type'] != '' && !empty($date['date_type'])) 
		? ' (' . $date['date_type'].')' 
		: '';

	if (trim($display_temp) == '' || trim($display_temp) == 'CE' || trim($display_temp) == 'BCE') 
	{ 
		$display_temp = '--'; 
	}

	$imageDates[] = array($display_temp=>$date['display']);

}

//------------------
//	 Query Materials
//------------------

$sql = "SELECT * 
			FROM $DB_NAME.material 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageMaterials = db_query($mysqli, $sql);

$imageMaterials = array();

while ($material = $result_imageMaterials->fetch_assoc()) {

	$material_AID = $material['material_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($material_AID == '') 
		? '<span class="mediumWeight purple">[UD]</span> ' 
		: '';

	$display_temp.= (!empty($material['material_text'])) 
		? $material['material_text'] 
		: '';

	$display_temp.= (!empty($material['material_type'])) 
		? ' ('.$material['material_type'].')' 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageMaterials[] = array($display_temp=>$material['display']);

}

//-------------------
//	 Query Techniques
//-------------------

$sql = "SELECT * 
			FROM $DB_NAME.technique 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageTechniques = db_query($mysqli, $sql);

$imageTechniques = array();

while ($technique = $result_imageTechniques->fetch_assoc()) {

	$technique_AID = $technique['technique_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($technique_AID == '') 
			? '<span class="mediumWeight purple">[UD]</span> ' 
			: '';

	$display_temp.= (!empty($technique['technique_text'])) 
		? $technique['technique_text'] 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageTechniques[] = array($display_temp=>$technique['display']);

}

//-------------------
//	 Query Work Types
//-------------------

$sql = "SELECT * 
			FROM $DB_NAME.work_type 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageWorkTypes = db_query($mysqli, $sql);

$imageWorkTypes = array();

while ($imageWorkType = $result_imageWorkTypes->fetch_assoc()) {

	$imageType_AID = $imageWorkType['work_type_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($imageWorkType == '') 
		? '<span class="mediumWeight purple">[UD]</span> ' 
		: '';

	$display_temp.= (!empty($imageWorkType['work_type_text'])) 
		? $imageWorkType['work_type_text'] 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageWorkTypes[] = array($display_temp=>$imageWorkType['display']);

}

//--------------------------
//	 Query Cultural Contexts
//--------------------------

$sql = "SELECT * 
			FROM $DB_NAME.culture 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageCultures = db_query($mysqli, $sql);

$imageCultures = array();

while ($culture = $result_imageCultures->fetch_assoc()) {

	$culture_AID = $culture['culture_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($culture_AID == '') 
		? '<span class="mediumWeight purple">[UD]</span> ' 
		: '';
	$display_temp.= (!empty($culture['culture_text'])) 
		? $culture['culture_text'] 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageCultures[] = array($display_temp=>$culture['display']);

}

//----------------------
//	 Query Style Periods
//----------------------

$sql = "SELECT * 
			FROM $DB_NAME.style_period 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageStylePeriods = db_query($mysqli, $sql);

$imageStylePeriods = array();

while ($stylePeriod = $result_imageStylePeriods->fetch_assoc()) {

	$stylePeriod_AID = $stylePeriod['style_period_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($stylePeriod_AID == '') 
		? '<span class="mediumWeight purple">[UD]</span> ' 
		: '';

	$display_temp.= (!empty($stylePeriod['style_period_text'])) 
		? $stylePeriod['style_period_text'] 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageStylePeriods[] = array($display_temp=>$stylePeriod['display']);

}

//------------------
//	 Query Locations
//------------------

$sql = "SELECT * 
			FROM $DB_NAME.location 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageLocations = db_query($mysqli, $sql);

$imageLocations = array();

while ($location = $result_imageLocations->fetch_assoc()) {

	$location_AID = $location['location_getty_id'];
	
	$display_temp = '';
	$display_temp .= ($location_AID == '') 
		? '<span class="mediumWeight purple">[UD]</span> ' 
		: '';

	$display_temp .= (!empty($location['location_type'])) 
		? $location['location_type'].': ' 
		: '';

	$display_temp .= (!empty($location['location_text'])) 
		? $location['location_text'] 
		: '';

	$display_temp .= (!empty($location['location_name_type'])) 
		? ' ('.$location['location_name_type'].')' 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}

	$imageLocations[] = array($display_temp=>$location['display']);

}

//--------------------
//	 Query Description
//--------------------

$trimmed_id = ltrim($_SESSION['imageNum'], '0');

$sql = "SELECT description 
			FROM $DB_NAME.image 
			WHERE id = '{$trimmed_id}' ";

$result_imageDescription = db_query($mysqli, $sql);

while ($description = $result_imageDescription->fetch_assoc()) {

	$imageDescription = (!empty($description['description']) || $description['description'] != '') 
		? $description['description'] 
		: '--';
		
}

//----------------------
//	 Query State/Edition
//----------------------

$sql = "SELECT * 
			FROM $DB_NAME.edition 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageEditions = db_query($mysqli, $sql);

$imageEditions = array();

while ($edition = $result_imageEditions->fetch_assoc()) {

	$display_temp = '';
	$display_temp.= (!empty($edition['edition_text'])) 
		? $edition['edition_text'].': ' 
		: '';

	$display_temp.= (!empty($edition['edition_type'])) 
		? ' ('.$edition['edition_type'].')' 
		: '';

	if (trim($display_temp) == '') { 
		$display_temp = '--'; 
	}

	$imageEditions[] = $display_temp;

}

//----------------------
//	 Query Measurements
//----------------------

$sql = "SELECT * 
			FROM $DB_NAME.measurements 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageMeasurements = db_query($mysqli, $sql);

$imageMeasurements = array();
$basicMeasurementTypes = array('Area','Bit depth','Circumference','Count','Depth','Diameter','Distance between','File size','Height','Length','Scale','Size','Weight','Width','Other');
$basicUnitMeasurements = array('Circumference','Depth','Diameter','Distance between','Height','Length','Width');

while ($measure = $result_imageMeasurements->fetch_assoc()) {

	$measure_temp = '';
		
	if (in_array($measure['measurements_type'], $basicMeasurementTypes)) {
	// Meaasurement is a basic type that uses the normal text input field
	
		$measure_temp = $measure['measurements_text'];
		
		if ($measure['measurements_type'] == 'Area') {
		
			$measure_temp.= ' '.$measure['area_unit'];
			
		} elseif ($measure['measurements_type'] == 'Bit depth') {
		
			$measure_temp.= ' bit';
		
		} elseif (in_array($measure['measurements_type'], $basicUnitMeasurements)) {
		
			$measure_temp.= ' '.$measure['measurements_unit'];
			
		} elseif ($measure['measurements_type'] == 'File size') {
		
			$measure_temp.= ' '.$measure['filesize_unit'];
		
		} elseif ($measure['measurements_type'] == 'Scale') {
		
			$measure_temp.= ' equals '.$measure['measurements_text_2'].' '.$measure['measurements_unit_2'];
		
		} elseif ($measure['measurements_type'] == 'Weight') {
		
			$measure_temp.= ' '.$measure['weight_unit'];
		
		} elseif ($measure['measurements_type'] == 'Other') {
		
			$measure_temp.= ' - '.$measure['measurements_description'];
		
		}
		
		if ($measure['measurements_unit'] == 'ft' && $measure['inches_value'] != '0') {
		
			$measure_temp.= ', '.$measure['inches_value'].' in';
		
		}
	
	} elseif ($measure['measurements_type'] == 'Duration' || $measure['measurements_type'] == 'Running time') {
	// Measurement is a duration, so uses the duration fields
	
		$measure_temp = ($measure['duration_days'] != '0') 
			? $measure['duration_days'] . ' days' 
			: '';

		$measure_temp.= ($measure['duration_days'] != '0' && $measure['duration_hours'] != '0') 
			? ', ' 
			: '';

		$measure_temp.= ($measure['duration_hours'] != '0') 
			? $measure['duration_hours'] . ' hours' 
			: '';

		$measure_temp.= ($measure['duration_hours'] != '0' && $measure['duration_minutes']) ? ', ' : '';

		$measure_temp.= ($measure['duration_minutes'] != '0') 
			? $measure['duration_minutes'].' minutes' 
			: '';

		$measure_temp.= ($measure['duration_minutes'] != '0' && $measure['duration_seconds'] != '0') 
			? ', ' 
			: '';

		$measure_temp.= ($measure['duration_seconds'] != '0') 
			? $measure['duration_seconds'].' seconds' 
			: '';
	
	} elseif ($measure['measurements_type'] == 'Resolution') {
	// Measurement is a screen resolution, so uses the resolution field
	
		$measure_temp = $measure['resolution_width'].' x '.$measure['resolution_height'];
	
	}
	
	$measure_temp = (isset($measure_temp) && !empty($measure_temp)) 
		? $measure_temp.' ('.$measure['measurements_type'].')' 
		: '--';

	$imageMeasurements[] = array($measure_temp=>$measure['display']);

}

//-----------------
//	 Query Subjects
//-----------------

$sql = "SELECT * 
			FROM $DB_NAME.subject 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageSubjects = db_query($mysqli, $sql);

$imageSubjects = array();

while ($subject = $result_imageSubjects->fetch_assoc()) {

	$subject_AID = $subject['subject_getty_id'];
	
	$display_temp = '';
	$display_temp.= ($subject_AID == '') 
		? '<span class="mediumWeight purple">[UD]</span> ' 
		: '';

	$display_temp.= (!empty($subject['subject_text'])) 
		? $subject['subject_text'] 
		: '';

	$display_temp.= (!empty($subject['subject_type'])) 
		? ' ('.$subject['subject_type'].')' 
		: '';
	
	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
	{ 
		$display_temp = '--'; 
	}
	
	$imageSubjects[] = array($display_temp=>$subject['display']);

}

//--------------------
//	 Query Inscription
//--------------------

$sql = "SELECT * 
			FROM $DB_NAME.inscription 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageInscriptions = db_query($mysqli, $sql);

$imageInscriptions = array();

while ($inscription = $result_imageInscriptions->fetch_assoc()) {

	$display_temp = '';
	$display_temp.= (!empty($inscription['inscription_type'])) 
		? $inscription['inscription_type'].': ' 
		: '';

	$display_temp.= (!empty($inscription['inscription_text'])) 
		? '"'.$inscription['inscription_text'].'"' 
		: '';

	$display_temp.= (!empty($inscription['inscription_author'])) 
		? ' by '.$inscription['inscription_author'] 
		: '';

	$display_temp.= (!empty($inscription['inscription_location'])) 
		? '<br>Location: '.$inscription['inscription_location'] 
		: '';

	if (trim($display_temp) == '') { 
		$display_temp = '--'; 
	}

	$imageInscriptions[] = array($display_temp=>$inscription['display']);

}

//--------------------
//	 Query Rights
//--------------------

$sql = "SELECT * 
			FROM $DB_NAME.rights 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageRights = db_query($mysqli, $sql);

$imageRights = array();

while ($rights = $result_imageRights->fetch_assoc()) {

	$display_temp = '';
	$display_temp.= (!empty($rights['rights_holder'])) 
		? $rights['rights_holder'].' ' 
		: '';

	$display_temp.= (!empty($rights['rights_type'])) 
		? '('.$rights['rights_type'].')' 
		: '';

	$display_temp.= (!empty($rights['rights_text'])) 
		? '<br>'.$rights['rights_text'] 
		: '';

	if (trim($display_temp) == '') { 
		$display_temp = '--'; 
	}

	$imageRights[] = $display_temp;

}

//--------------------
//	 Query Source
//--------------------

$sql = "SELECT * 
			FROM $DB_NAME.source 
			WHERE related_images = '{$_SESSION['imageNum']}' ";

$result_imageSources = db_query($mysqli, $sql);

$imageSources = array();

while ($source = $result_imageSources->fetch_assoc()) {

	$display_temp = '';
	$display_temp.= (!empty($source['source_name_text'])) 
		? $source['source_name_text'] 
		: '';

	$display_temp.= (!empty($source['source_name_type'])) 
		? ' ('.$source['source_name_type'].')' 
		: '';

	$display_temp.= (!empty($source['source_type'])) 
		? '<br>'.$source['source_type'].': ' 
		: '';

	$display_temp.= (!empty($source['source_text'])) 
		? $source['source_text'] 
		: '';

	if (trim($display_temp) == '') { 
		$display_temp = '--'; 
	}
	
	$imageSources[] = $display_temp;

}
