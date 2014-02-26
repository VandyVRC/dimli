<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/functions.php');


if ($_SESSION['workNum'] != 'None') {
// There is an associated work for this image record

	//-----------------
	//	 Query Updates
	//-----------------

	$sql = "SELECT * 
				FROM $DB_NAME.work 
				WHERE id = '{$_SESSION['workNum']}' ";

	$result_workUpdates = db_query($mysqli, $sql);

	while ($work = $result_workUpdates->fetch_assoc()) {

		$last_update = 	$work['last_update'];
		$last_update_by = $work['last_update_by'];
		$created = 			$work['created'];
		$created_by = 		$work['created_by'];

	}

	//---------------
	//	 Query Titles
	//---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.title 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workTitles = db_query($mysqli, $sql);
	
	$workTitles = array();
	
	while ($title = $result_workTitles->fetch_assoc()) {
	
		$title_text = $title['title_text'];
		$title_type = $title['title_type'];
		
		$display_temp = '';
		$display_temp.= ($title_text != '') 
			? $title_text 
			: '';

		$display_temp.= ($title_type != '') 
			? ' ('.$title_type.')' 
			: '';

		$workTitles[] = array($display_temp=>$title['display']);
	
	}
	
	//---------------
	//	 Query Agents
	//---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.agent 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workAgents = db_query($mysqli, $sql);
	
	$workAgents = array();
	
	while ($agent = $result_workAgents->fetch_assoc()) {
	
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
			? $agent_attr.' ' 
			: '';

		$display_temp.= (!empty($agent_text)) 
			? $agent_text 
			: '';

		$display_temp.= (!empty($agent_role)) 
			? ' ('.$agent_role.')' 
			: '';

		if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
		{ 
			$display_temp = '--'; 
		}

		$workAgents[] = array($display_temp=>$agent['display']);
	
	}
	
	//---------------
	//	 Query Dates
	//---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.date 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workDates = db_query($mysqli, $sql);
	
	$workDates = array();
	
	while ($date = $result_workDates->fetch_assoc()) {
	
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
			? ' ('.$date['date_type'].')' 
			: '';

		if (trim($display_temp) == '' || trim($display_temp) == 'CE' || trim($display_temp) == 'BCE') 
		{ 
			$display_temp = '--'; 
		}

		$workDates[] = array($display_temp=>$date['display']);
	
	}
	
	//------------------
	//	 Query Materials
	//------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.material 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workMaterials = db_query($mysqli, $sql);
	
	$workMaterials = array();
	
	while ($material = $result_workMaterials->fetch_assoc()) {
	
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

		$workMaterials[] = array($display_temp=>$material['display']);
	
	}
	
	//-------------------
	//	 Query Techniques
	//-------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.technique 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workTechniques = db_query($mysqli, $sql);
	
	$workTechniques = array();
	
	while ($technique = $result_workTechniques->fetch_assoc()) {
	
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

		$workTechniques[] = array($display_temp=>$technique['display']);
	
	}
	
	//-------------------
	//	 Query Work Types
	//-------------------
	
	$sql = "SELECT *
				FROM $DB_NAME.work_type 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workWorkTypes = db_query($mysqli, $sql);
	
	$workWorkTypes = array();
	
	while ($workType = $result_workWorkTypes->fetch_assoc()) {
	
		$workType_AID = $workType['work_type_getty_id'];
		
		$display_temp = '';
		$display_temp.= ($workType_AID == '') 
			? '<span class="mediumWeight purple">[UD]</span> ' 
			: '';

		$display_temp.= (!empty($workType['work_type_text'])) 
			? $workType['work_type_text'] 
			: '';
		
		if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
		{ 
			$display_temp = '--'; 
		}

		$workWorkTypes[] = array($display_temp=>$workType['display']);
	
	}
	
	//--------------------------
	//	 Query Cultural Contexts
	//--------------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.culture 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workCultures = db_query($mysqli, $sql);
	
	$workCultures = array();
	
	while ($culture = $result_workCultures->fetch_assoc()) {
	
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

		$workCultures[] = array($display_temp=>$culture['display']);
	
	}
	
	//----------------------
	//	 Query Style Periods
	//----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.style_period 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workStylePeriods = db_query($mysqli, $sql);
	
	$workStylePeriods = array();
	
	while ($stylePeriod = $result_workStylePeriods->fetch_assoc()) {
	
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

		$workStylePeriods[] = array($display_temp=>$stylePeriod['display']);
	
	}
	
	//------------------
	//	 Query Locations
	//------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.location 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workLocations = db_query($mysqli, $sql);
	
	$workLocations = array();
	
	while ($location = $result_workLocations->fetch_assoc()) {
	
		$location_AID = $location['location_getty_id'];
		
		$display_temp = '';
		$display_temp.= ($location_AID == '') 
			? '<span class="mediumWeight purple">[UD]</span> ' 
			: '';

		$display_temp.= (!empty($location['location_type'])) 
			? $location['location_type'].': ' 
			: '';

		$display_temp.= (!empty($location['location_text'])) 
			? $location['location_text'] 
			: '';

		$display_temp.= (!empty($location['location_name_type'])) 
			? ' ('.$location['location_name_type'].')' 
			: '';
		
		if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> ') 
		{ 
			$display_temp = '--'; 
		}

		$workLocations[] = array($display_temp=>$location['display']);
	
	}
	
	//--------------------
	//	 Query Description
	//--------------------
	
	$trimmed_id = ltrim($_SESSION['workNum'], '0');

	$sql = "SELECT description 
				FROM $DB_NAME.work 
				WHERE id = '{$trimmed_id}' ";

	$result_workDescription = db_query($mysqli, $sql);
	
	while ($description = $result_workDescription->fetch_assoc()) {
	
		$workDescription = ($description['description'] != '') 
			? $description['description'] 
			: '--';
			
	}
	
	//----------------------
	//	 Query State/Edition
	//----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.edition 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workEditions = db_query($mysqli, $sql);
	
	$workEditions = array();
	
	while ($edition = $result_workEditions->fetch_assoc()) {
	
		$display_temp = '';
		$display_temp.= (!empty($edition['edition_text'])) 
			? $edition['edition_text'].': ' 
			: '';

		$display_temp.= (!empty($edition['edition_type'])) 
			? ' ('.$edition['edition_type'].')' 
			: '';

		if ($display_temp == '') { 
			$display_temp = '--'; 
		}

		$workEditions[] = $display_temp;
	
	}
	
	//----------------------
	//	 Query Measurements
	//----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.measurements 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workMeasurements = db_query($mysqli, $sql);
	
	$workMeasurements = array();
	$basicMeasurementTypes = array('Area','Bit depth','Circumference','Count','Depth','Diameter','Distance between','File size','Height','Length','Scale','Size','Weight','Width','Other');
	$basicUnitMeasurements = array('Circumference','Depth','Diameter','Distance between','Height','Length','Width');
	
	while ($measure = $result_workMeasurements->fetch_assoc()) {
	
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
				? $measure['duration_hours'].' hours' 
				: '';

			$measure_temp.= ($measure['duration_hours'] != '0' && $measure['duration_minutes']) 
				? ', ' 
				: '';

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

		$workMeasurements[] = array($measure_temp=>$measure['display']);
	}
	
	//-----------------
	//	 Query Subjects
	//-----------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.subject 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workSubjects = db_query($mysqli, $sql);
	
	$workSubjects = array();
	
	while ($subject = $result_workSubjects->fetch_assoc()) {
	
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
		
		$workSubjects[] = array($display_temp=>$subject['display']);
	
	}
	
	//--------------------
	//	 Query Inscription
	//--------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.inscription 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workInscriptions = db_query($mysqli, $sql);
	
	$workInscriptions = array();
	
	while ($inscription = $result_workInscriptions->fetch_assoc()) {
	
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

		if ($display_temp == '') { 
			$display_temp = '--'; 
		}

		$workInscriptions[] = array($display_temp=>$inscription['display']);
	
	}
	
	//--------------------
	//	 Query Rights
	//--------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.rights 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workRights = db_query($mysqli, $sql);
	
	$workRights = array();
	
	while ($rights = $result_workRights->fetch_assoc()) {
	
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

		if ($display_temp == '') { 
			$display_temp = '--'; 
		}

		$workRights[] = $display_temp;
	
	}
	
	//--------------------
	//	 Query Source
	//--------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.source 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_workSources = db_query($mysqli, $sql);
	
	$workSources = array();
	
	while ($source = $result_workSources->fetch_assoc()) {
	
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

		if ($display_temp == '') { 
			$display_temp = '--'; 
		}
		
		$workSources[] = $display_temp;
	
	}

	//-------------------------
	//	 Query Preferred Image
	//-------------------------

	$sql = "SELECT preferred_image 
				FROM $DB_NAME.work 
				WHERE id = '{$_SESSION['workNum']}' ";

	$result_prefImage = db_query($mysqli, $sql);

	while ($row = $result_prefImage->fetch_assoc())
	{
		$work_thumb_id = $row['preferred_image'];

		$sql ="SELECT legacy_id 
					FROM $DB_NAME.image 
					WHERE id ='{$work_thumb_id}'";

					$result_prefLegId = db_query($mysqli, $sql);

				while ($row = $result_prefLegId->fetch_assoc()){
				$prefLegId = $row['legacy_id'];
				$work_thumb_file = 'mdidimages/HoAC/thumb/'.$prefLegId.'.jpg';
				}
	}

	//-------------------------
	//	 Query Related Images
	//-------------------------

	$sql = "SELECT * 
				FROM $DB_NAME.image 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result_assocImages = db_query($mysqli, $sql);
	$associatedImages_ct = $result_assocImages->num_rows;

} 
elseif ($_SESSION['workNum'] == 'None')
// There is no associated work for this image record
{

	$work_thumb_id = 'None';

}
