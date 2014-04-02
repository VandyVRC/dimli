<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_orders_read');

// Use Image number passed from ajax request to find the associated work

$sql = "SELECT related_works 
			FROM $DB_NAME.image 
			WHERE id = '{$_GET['imageRecord']}' LIMIT 1 ";

$workToLoad_r = db_query($mysqli, $sql);

// Set SESSION workNum, or set to "None" if field is blank

while ($row = $workToLoad_r->fetch_assoc())
{
	$workNum = 
		(!empty($row['related_works']))
			? $row['related_works']
			: 'None';
}


if ($workNum != 'None') {
// There is an associated work for this image record

	//-----------------
	//	 Query Updates
	//-----------------

	$sql = "SELECT * 
				FROM $DB_NAME.work 
				WHERE id = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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

	//----------------------
	//	 Query Measurements
	//----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.measurements 
				WHERE related_works = '{$workNum}' ";

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
	
	//--------------------------
	//	 Query Cultural Contexts
	//--------------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.culture 
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
	
	//-----------------
	//	 Query Locations 
	//------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.location 
				WHERE related_works = '{$workNum}' 
				AND location_getty_id NOT REGEXP 'work' ";

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
		
			 	if ($display_temp == '' || $display_temp == '<span class="mediumWeight purple">[UD]</span> '){ 
				$display_temp = '--'; 		
				}

				$workLocations[] = array($display_temp=>$location['display']);	
		
			}

	//---------------------------
	//	 Query Specific Location
	//---------------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.specific_location 
				WHERE related_works = '{$workNum}' ";
	
	$result_specificLocation = db_query($mysqli, $sql);

	$workSpecificLocations = array();

	while ($specific = $result_specificLocation->fetch_assoc()) {

		$display_temp = '';

		$display_temp.= (!empty($specific['specific_location_address'])) 
			? $specific['specific_location_address'].', ' 
			: '';

		$display_temp.= (!empty($specific['specific_location_zip'])) 
			? $specific['specific_location_zip'] 
			: '';

		$display_temp.= (!empty($specific['specific_location_lat'])) 
			? $specific['specific_location_lat'].', '  
			: '';

		$display_temp.= (!empty($specific['specific_location_long'])) 
			? $specific['specific_location_long'] 
			: '';

		$display_temp.= (!empty($specific['specific_location_note'])) 
			? $specific['specific_location_note'] 
			: '';		

		if ($display_temp == '') { 
			$display_temp = '--'; 
		}

		$workSpecificLocations[] = array($display_temp=>$specific['display']);
	}

	//---------------------------
	//	 Query Built Work
	//---------------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.location 
				WHERE related_works = '{$workNum}'
				AND location_getty_id REGEXP 'work' ";

	$result_builtWork = db_query($mysqli, $sql);

	$workBuiltWork = array();

	if ($result_builtWork->num_rows <1){

		$display_temp = '--'; 
		$builtWork['display'] = '1';
	
		$workBuiltWork[] = array($display_temp=>$builtWork['display']);		
	}
	
	else{
		
		while ($builtWork = $result_builtWork->fetch_assoc()) {
	
				$display_temp ='';

				$display_temp.= (!empty($builtWork['location_type'])) 
					? $builtWork['location_type'].': ' 
					: '';

				$display_temp.= (!empty($builtWork['location_text'])) 
					? $builtWork['location_text'] 
					: '';

				$display_temp.= (!empty($builtWork['location_name_type'])) 
					? ' ('.$builtWork['location_name_type'].')'

					: '';	

				if ($display_temp == ''){ 
				$display_temp = '--'; 
				}

				$workBuiltWork[] = array($display_temp=>$builtWork['display']);	
			}
	}

	//--------------------
	//	 Query Relation
	//--------------------

	$sql = "SELECT  relation_id, display
				FROM $DB_NAME.relation 
				WHERE related_works = '{$workNum}' ";

	$result_relation = db_query($mysqli, $sql);
	
	$workRelation = array();
	
	while ($relation = $result_relation->fetch_assoc()) {
		
		if (!empty($relation['relation_id'])) {
			
			$getRelated = $relation['relation_id'];					

		$sql = "SELECT preferred_image 
							FROM $DB_NAME.work
							WHERE id = '{$getRelated}' 
							LIMIT 1 " ;

				$result_getPref = db_query($mysqli, $sql); 	

				while ($getPreferred = $result_getPref->fetch_assoc()) {

					$preferredImage = $getPreferred['preferred_image'];	
				}		

			if (!empty($preferredImage)) {	

			$sql = "SELECT legacy_id 
						FROM $DB_NAME.image
						WHERE id = '{$preferredImage}' ";	

				$result_getLeg	= db_query($mysqli, $sql); 
				
				while ($getLegacy = $result_getLeg->fetch_assoc()) {

					$legacyId = $getLegacy['legacy_id'];
					$imageView = '
					<img class="relatedWork_image"
					src="'.$webroot.'/_plugins/timthumb/timthumb.php?src='.$image_src.'medium/'.$legacyId.'.jpg&amp;h=40&amp;w=53&amp;q=90"
					title="Click to preview"
						style="max-height: 40px; max-width: 53px;">
						<input type="hidden" id="imageView" value="'.$legacyId.'">
						<input type="hidden" id="imageNum" value="'.$preferredImage.'">';
				}
			}						

			$sql = "SELECT title_text
					FROM $DB_NAME.title
					WHERE related_works = '{$getRelated}'
					LIMIT 1 " ;

				$result_getTitle = db_query($mysqli, $sql); 	

				while ($getRelatedTitle = $result_getTitle->fetch_assoc()) {

					$relatedTitle = $getRelatedTitle['title_text'];
				}

			$sql = "SELECT agent_text
					FROM $DB_NAME.agent
					WHERE related_works = '{$getRelated}'
					LIMIT 1 ";	

				$result_getAgent = db_query($mysqli, $sql); 	

				while ($getRelatedAgent = $result_getAgent->fetch_assoc()) {

					$relatedAgent = $getRelatedAgent['agent_text'];
					$relatedAgentDisplay = (!empty($relatedAgent)) 
						? ' ('.$relatedAgent.')'
						: '';	
				}	
			}	

		$display_temp = '';

		$display_temp = (!empty($legacyId))
			? $imageView
			:'';
			
		$display_temp.= (!empty($relatedTitle)) 
			? 	'<div class="related_title" style="display: inline-block; width: 200px; float: right;"><div class="assocImage_title">'.$relatedTitle.$relatedAgentDisplay.'</div></div>'		
			: '';	

		if ($display_temp == '') { 
			$display_temp = '--'; 
		}
			
		$workRelation[] = array($display_temp=>$relation['display']);	
	}
	
	
	//----------------------
	//	 Query State/Edition
	//----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.edition 
				WHERE related_works = '{$workNum}' ";

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

	//--------------------
	//	 Query Inscription
	//--------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.inscription 
				WHERE related_works = '{$workNum}' ";

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
	
	//-----------------
	//	 Query Subjects
	//-----------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.subject 
				WHERE related_works = '{$workNum}' ";

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
	//	 Query Description
	//--------------------
	
	$trimmed_id = ltrim($workNum, '0');

	$sql = "SELECT description 
				FROM $DB_NAME.work 
				WHERE id = '{$trimmed_id}' ";

	$result_workDescription = db_query($mysqli, $sql);
	
	while ($description = $result_workDescription->fetch_assoc()) {
	
		$workDescription = ($description['description'] != '') 
			? $description['description'] 
			: '--';
			
	}
	
	//--------------------
	//	 Query Rights
	//--------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.rights 
				WHERE related_works = '{$workNum}' ";

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
				WHERE related_works = '{$workNum}' ";

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
				WHERE id = '{$workNum}' ";

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
				$work_thumb_file = $image_dir.'/thumb/'.$prefLegId.'.jpg';
				}
	}

	//-------------------------
	//	 Query Related Images
	//-------------------------

	$sql = "SELECT * 
				FROM $DB_NAME.image 
				WHERE related_works = '{$workNum}' ";

	$result_assocImages = db_query($mysqli, $sql);
	$associatedImages_ct = $result_assocImages->num_rows;

} 
elseif ($workNum == 'None')
// There is no associated work for this image record
{

	$work_thumb_id = 'None';

}

	if ($workNum != 'None')
	// An associated work record DOES EXIST for the current image
	{ ?>

<div id="workRecord_catalogInfo" class="workRecord_catalogInfo">

	<div class="record_updateInfo grey mediumWeight">

		<div style="margin-bottom: 8px;">
			
			CREATED:<br>

			<?php echo (!empty($created)) 
				? strtoupper(date('D, M d, Y', strtotime($created))) 
				: '--'; ?>
			<?php echo (!empty($created_by)) 
				? ' by '. strtoupper($created_by) 
				: ''; ?>

		</div>

		<div style="margin-bottom: 8px;">

			UPDATED:<br>

			<?php echo (!empty($last_update)) 
				? strtoupper(date('D, M d, Y', strtotime($last_update))) 
				: '--'; ?>
			<?php echo (!empty($last_update_by)) 
				? ' by '. strtoupper($last_update_by) 
				: ''; ?>

		</div>

	</div>

	<!-- 
		THUMBNAIL PREVIEW
	 -->

	<div class="workRecord_thumb"
		style="position: absolute; top: 0; right: 0;">

		<?php
		
		if (isset($prefLegId) && !in_array($work_thumb_id, array('','0'))) //&& checkRemoteFile($image_dir.'thumb/'.$prefLegId.'.jpg')) 
		{
		// IF a preferred image is assigned for this work record
		?>

		<img class="catThumb" src="<?php echo $work_thumb_file; ?>"
			onclick="image_viewer('<?php echo $prefLegId; ?>');">

		<?php
		}

		else if ($workNum != 'None' &&
 -			$workNum != '')
		{
		?>

		<div class="record_thumbnail"
			style="margin-right: 5px;">No preview</div>

		<?php
		}
		?>

	</div>

	<p class="clear"></p>
	
	<!--
		Title
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Title:</div>

		<div class="content_lineText mediumWeight"><?php
			if (!empty($workTitles)) {
				foreach ($workTitles as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Agent
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Agent:</div>

		<div class="content_lineText"><?php
			if (!empty($workAgents)) {
				foreach ($workAgents as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Date
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Date:</div>

		<div class="content_lineText"><?php
			if (!empty($workDates)) {
				foreach ($workDates as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Materials
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Material:</div>

		<div class="content_lineText"><?php
			if (!empty($workMaterials)) {
				foreach ($workMaterials as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Techniques
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Technique:</div>

		<div class="content_lineText"><?php
			if (!empty($workTechniques)) {
				foreach ($workTechniques as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Work Types
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Work Type:</div>

		<div class="content_lineText"><?php
			if (!empty($workWorkTypes)) {
				foreach ($workWorkTypes as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>

	<!--
		Measurements
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Measure:</div>

		<div class="content_lineText"><?php
			if (!empty($workMeasurements)) {
				foreach ($workMeasurements as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Cultural Contexts
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Culture:</div>

		<div class="content_lineText"><?php
			if (!empty($workCultures)) {
				foreach ($workCultures as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Style Periods
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Style Period:</div>

		<div class="content_lineText"><?php
			if (!empty($workStylePeriods)) {
				foreach ($workStylePeriods as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Location
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Location:</div>

		<div class="content_lineText"><?php
			if (!empty($workLocations)) {
				foreach ($workLocations as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>

	<!--
		Specific Location
	-->

	<div class="content_line">

		<div class="content_lineTitle">Specific Location:</div>

		<div class="content_lineText"><?php
			if (!empty($workSpecificLocations)) {
				foreach ($workSpecificLocations as $datum) {
					
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				  
				}
			}
		?></div>

	</div>

	<!--
		Built Work
	-->

	<div class="content_line">

		<div class="content_lineTitle">Built Work:</div>

		<div class="content_lineText"><?php
			if (!empty($workBuiltWork)) {
				foreach ($workBuiltWork as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>

	<!--
		Related Works
	-->

	<div class="content_line">

		<div class="content_lineTitle">Related Works:</div>

		<div class="content_lineText"><?php
		if (!empty($workRelation)) {
				foreach ($workRelation as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		State/Edition
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Edition:</div>

		<div class="content_lineText"><?php
			if (!empty($workEditions)) {
				foreach ($workEditions as $disp) {
					echo $disp . '<br>';
				}
			}
		?></div>

	</div>
	
	<!--
		Inscriptions
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Inscription:</div>

		<div class="content_lineText"><?php
			if (!empty($workInscriptions)) {
				foreach ($workInscriptions as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>
	
	<!--
		Subjects
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Subject:</div>

		<div class="content_lineText"><?php
			if (!empty($workSubjects)) {
				foreach ($workSubjects as $datum) {
					foreach ($datum as $disp=>$toggle) {
						echo ($toggle=='0') ? '<span class="ital lightGrey">' : '';
						echo $disp . '<br>';
						echo ($toggle=='0') ? '</span>' : '';
					}
				}
			}
		?></div>

	</div>

	<!--
		Description
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Description:</div>

		<div class="content_lineText"><?php
			echo (!empty($workDescription)) ? $workDescription : '--';
		?></div>

	</div>

	<!--
		Rights
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Rights:</div>

		<div class="content_lineText" style="word-wrap: break-word;"><?php
			if (!empty($workRights)) { foreach ($workRights as $rights) { echo $rights . '<br>'; } }
		?></div>

	</div>
	
	<!--
		Sources
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Source:</div>

		<div class="content_lineText" style="word-wrap: break-word;"><?php
			if (!empty($workSources)) { foreach ($workSources as $source) { echo $source . '<br>'; } }
		?></div>

	</div>

<?php } ?>

</div>

<script>
	//Append Work Number to Module Header
	var workNum = $.trim(<?php echo json_encode($workNum);?>);
	// console.log(workNum+' added to the header of the work record'); // Debug

	$('div#relation_work_module h1').append('<div class="floatRight" style="margin-right: 10px;">' + workNum + '</div>');


</script>
