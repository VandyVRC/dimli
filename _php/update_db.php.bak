<?php
require_priv('priv_catalog');

// Variables $recordType and $recordNum are set by 
// 'updateWork_script.php' and 'updateImage_script.php', 
// both of which contain an include to this file

//	Set abbreviation to 'W' or 'I'
//---------------------------------
if ($recordType == 'work')
{
	$abbr = 'W';
	$field_type = 'work';
}
elseif ($recordType == 'image')
{
	$abbr = 'I';
	$field_type = 'image';
}
elseif ($recordType == 'createNewWork')
{
	$abbr = 'NW';
	$field_type = 'work';
}

// echo 'record type: '.$recordType.'<br>'; // Debug
// echo 'record number: '.$recordNum.'<br>'; // Debug
// echo 'field type: '.$field_type.'<br>'; // Debug

//------------------
//		TITLES
//------------------

if (!empty($recordNum) && $recordNum != '')
{
	// Remove old title info
	$query = "DELETE FROM dimli.title 
					WHERE related_".$field_type."s = '{$recordNum}' ";
					
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['titleArray'][$recordType])) {

	$sql = "INSERT INTO dimli.title VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['titleArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'titleType' . $i)) {
	
			$query = " UPDATE dimli.title 
						SET
							title_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'title' . $i)) {
		
			$query = " UPDATE dimli.title 
						SET
							title_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'titleDisplay' . $i)) {
		
			$query = " UPDATE dimli.title 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
		
	}
	$i ++;
}
	


//------------------
//		AGENTS
//------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.agent WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['agentArray'][$recordType])) {

	$sql = "INSERT INTO dimli.agent VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['agentArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'agentAttribution' . $i)) {
		
			$query = " UPDATE dimli.agent 
						SET
							agent_attribution = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'agent' . $i)) {
		
			$query = " UPDATE dimli.agent 
						SET
							agent_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentId' . $i)) {
		
			$query = " UPDATE dimli.agent 
						SET
							agent_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentType' . $i)) {
		
			$query = " UPDATE dimli.agent 
						SET
							agent_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentRole' . $i)) {
		
			$query = " UPDATE dimli.agent 
						SET
							agent_role = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentDisplay' . $i)) {
		
			$query = " UPDATE dimli.agent 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//------------------
//		DATES
//------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.date WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['dateArray'][$recordType])) {

	$sql = "INSERT INTO dimli.date VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;
		
	foreach ($_SESSION['dateArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'dateType' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							date_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'dateRange' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							date_range = '1'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'circaDate' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							date_circa = '1'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'startDate' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							date_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'startDateEra' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							date_era = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'endDate' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							enddate_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'endDateEra' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							enddate_era = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'dateDisplay' . $i)) {
		
			$query = " UPDATE dimli.date 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//---------------------
//		MATERIALS
//---------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.material WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['materialArray'][$recordType])) {

	$sql = "INSERT INTO dimli.material VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['materialArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'materialType' . $i)) {
		
			$query = " UPDATE dimli.material 
						SET
							material_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'material' . $i)) {
		
			$query = " UPDATE dimli.material 
						SET
							material_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'materialId' . $i)) {
		
			$query = " UPDATE dimli.material 
						SET
							material_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'materialDisplay' . $i)) {
		
			$query = " UPDATE dimli.material 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//----------------------
//		TECHNIQUES
//----------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.technique WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['techniqueArray'][$recordType])) {

	$sql = "INSERT INTO dimli.technique VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['techniqueArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'technique' . $i)) {
		
			$query = " UPDATE dimli.technique 
						SET
							technique_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'techniqueId' . $i)) {
		
			$query = " UPDATE dimli.technique 
						SET
							technique_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'techniqueDisplay' . $i)) {
		
			$query = " UPDATE dimli.technique 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//----------------------
//		WORK TYPES
//----------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.work_type WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['workTypeArray'][$recordType])) {

	$sql = "INSERT INTO dimli.work_type VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['workTypeArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'workType' . $i)) {
		
			$query = " UPDATE dimli.work_type 
						SET
							work_type_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'workTypeId' . $i)) {
		
			$query = " UPDATE dimli.work_type 
						SET
							work_type_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'workTypeDisplay' . $i)) {
		
			$query = " UPDATE dimli.work_type 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//------------------------------
//		CULTURAL CONTEXTS
//------------------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.culture WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['culturalContextArray'][$recordType])) {

	$sql = "INSERT INTO dimli.culture VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['culturalContextArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'culturalContext' . $i)) {
		
			$query = " UPDATE dimli.culture 
						SET
							culture_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'culturalContextId' . $i)) {
		
			$query = " UPDATE dimli.culture 
						SET
							culture_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'culturalContextDisplay' . $i)) {
		
			$query = " UPDATE dimli.culture 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//--------------------------
//		STYLE PERIODS
//--------------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.style_period WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['stylePeriodArray'][$recordType])) {

	$sql = "INSERT INTO dimli.style_period VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['stylePeriodArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'stylePeriod' . $i)) {
		
			$query = " UPDATE dimli.style_period 
						SET
							style_period_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'stylePeriodId' . $i)) {
		
			$query = " UPDATE dimli.style_period
						SET
							style_period_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'stylePeriodDisplay' . $i)) {
		
			$query = " UPDATE dimli.style_period 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//---------------------
//		LOCATIONS
//---------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.location WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['locationArray'][$recordType])) {

	$sql = "INSERT INTO dimli.location VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['locationArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'location' . $i)) {
		
			$query = " UPDATE dimli.location 
						SET
							location_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'locationId' . $i)) {
		
			$query = " UPDATE dimli.location
						SET
							location_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'locationNameType' . $i)) {
		
			$query = " UPDATE dimli.location
						SET
							location_name_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'locationType' . $i)) {
		
			$query = " UPDATE dimli.location
						SET
							location_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'locationDisplay' . $i)) {
		
			$query = " UPDATE dimli.location 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//--------------------------
//		STATE/EDITION
//--------------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.edition WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['stateEditionArray'][$recordType])) {

	$sql = "INSERT INTO dimli.edition VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['stateEditionArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'stateEditionType' . $i)) {
		
			$query = " UPDATE dimli.edition 
						SET
							edition_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'stateEdition' . $i)) {
		
			$query = " UPDATE dimli.edition
						SET
							edition_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//-----------------------
//		MEASUREMENTS
//-----------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.measurements WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['measurementsArray'][$recordType])) {

	$sql = "INSERT INTO dimli.measurements VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['measurementsArray'][$recordType] as $key=>$value) {
	
		if ($key == $abbr.'measurementType' . $i) {
		
			$query = " UPDATE dimli.measurements 
						SET
							measurements_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
			
		
		} elseif (strstr($key, $abbr.'measurementField1_' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							measurements_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'commonMeasurementList1_' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							measurements_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'measurementField2_' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							measurements_text_2 = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'commonMeasurementList2_' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							measurements_unit_2 = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'inchesValue' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							inches_value = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'areaMeasurementList' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							area_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'days' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							duration_days = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'hours' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							duration_hours = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'minutes' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							duration_minutes = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
			
		
		} elseif (strstr($key, $abbr.'seconds' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							duration_seconds = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'fileSize' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							filesize_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'resolutionWidth' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							resolution_width = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'resolutionHeight' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							resolution_height = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'weightUnit' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							weight_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'otherMeasurementDescription' . $i)) {
		
			$query = " UPDATE dimli.measurements
						SET
							measurements_description = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'measurementDisplay' . $i)) {
		
			$query = " UPDATE dimli.measurements 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//--------------------
//		SUBJECTS
//--------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.subject WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['subjectArray'][$recordType])) {

	$sql = "INSERT INTO dimli.subject VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['subjectArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'subjectType' . $i)) {
		
			$query = " UPDATE dimli.subject 
						SET
							subject_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'subject' . $i)) {
		
			$query = " UPDATE dimli.subject
						SET
							subject_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'subjectId' . $i)) {
		
			$query = " UPDATE dimli.subject
						SET
							subject_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'subjectDisplay' . $i)) {
		
			$query = " UPDATE dimli.subject 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//------------------------
//		INSCRIPTIONS
//------------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.inscription WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['inscriptionArray'][$recordType])) {

	$sql = "INSERT INTO dimli.inscription VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['inscriptionArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'inscriptionType' . $i)) {
		
			$query = " UPDATE dimli.inscription 
						SET
							inscription_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'workInscription' . $i)) {
		
			$query = " UPDATE dimli.inscription
						SET
							inscription_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'workInscriptionAuthor' . $i)) {
		
			$query = " UPDATE dimli.inscription
						SET
							inscription_author = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'workInscriptionLocation' . $i)) {
		
			$query = " UPDATE dimli.inscription
						SET
							inscription_location = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'inscriptionDisplay' . $i)) {
		
			$query = " UPDATE dimli.inscription 
						SET
							display = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//------------------
//		RIGHTS
//------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM dimli.rights WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['rightsArray'][$recordType])) {

	$sql = "INSERT INTO dimli.rights VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['rightsArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'rightsType' . $i)) {
		
			$query = " UPDATE dimli.rights 
						SET
							rights_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'rightsHolder' . $i)) {
		
			$query = " UPDATE dimli.rights
						SET
							rights_holder = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'rightsText' . $i)) {
		
			$query = " UPDATE dimli.rights
						SET
							rights_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}



//----------------------
//		WORK SOURCE
//----------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = isnerQ("DELETE FROM dimli.source WHERE related_".$field_type."s = '{$recordNum}'");
}

$i = 0;

while ($i < countCatRows($_SESSION['sourceArray'][$recordType])) {

	$sql = "INSERT INTO dimli.source VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['sourceArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'sourceNameType' . $i)) {
		
			$query = " UPDATE dimli.source 
						SET
							source_name_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'sourceName' . $i)) {
		
			$query = " UPDATE dimli.source
						SET
							source_name_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'sourceType' . $i)) {
		
			$query = " UPDATE dimli.source
						SET
							source_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'source' . $i)) {
		
			$query = " UPDATE dimli.source
						SET
							source_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}
?>
<script>

	msg(['Catalog successfully updated'], 'success');

</script>