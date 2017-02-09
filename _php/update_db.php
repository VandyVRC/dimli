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
	$query = "DELETE FROM $DB_NAME.title 
					WHERE related_".$field_type."s = '{$recordNum}' ";
					
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['titleArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.title VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['titleArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'titleType' . $i)) {
	
			$query = " UPDATE $DB_NAME.title 
						SET
							title_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'title' . $i)) {
		
			$query = " UPDATE $DB_NAME.title 
						SET
							title_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'titleDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.title 
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
	$query = " DELETE FROM $DB_NAME.agent WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['agentArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.agent VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['agentArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'agentAttribution' . $i)) {
		
			$query = " UPDATE $DB_NAME.agent 
						SET
							agent_attribution = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'agent' . $i)) {
		
			$query = " UPDATE $DB_NAME.agent 
						SET
							agent_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentId' . $i)) {
		
			$query = " UPDATE $DB_NAME.agent 
						SET
							agent_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentType' . $i)) {
		
			$query = " UPDATE $DB_NAME.agent 
						SET
							agent_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentRole' . $i)) {
		
			$query = " UPDATE $DB_NAME.agent 
						SET
							agent_role = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'agentDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.agent 
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
	$query = " DELETE FROM $DB_NAME.date WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['dateArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.date VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;
		
	foreach ($_SESSION['dateArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'dateType' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							date_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'dateRange' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							date_range = '1'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'circaDate' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							date_circa = '1'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'startDate' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							date_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'startDateEra' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							date_era = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'endDate' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							enddate_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'endDateEra' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
						SET
							enddate_era = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'dateDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.date 
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
	$query = " DELETE FROM $DB_NAME.material WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['materialArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.material VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['materialArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'materialType' . $i)) {
		
			$query = " UPDATE $DB_NAME.material 
						SET
							material_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'material' . $i)) {
		
			$query = " UPDATE $DB_NAME.material 
						SET
							material_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'materialId' . $i)) {
		
			$query = " UPDATE $DB_NAME.material 
						SET
							material_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'materialDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.material 
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
	$query = " DELETE FROM $DB_NAME.technique WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['techniqueArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.technique VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['techniqueArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'technique' . $i)) {
		
			$query = " UPDATE $DB_NAME.technique 
						SET
							technique_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'techniqueId' . $i)) {
		
			$query = " UPDATE $DB_NAME.technique 
						SET
							technique_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'techniqueDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.technique 
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
	$query = " DELETE FROM $DB_NAME.work_type WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['workTypeArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.work_type VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['workTypeArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'workType' . $i)) {
		
			$query = " UPDATE $DB_NAME.work_type 
						SET
							work_type_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'workTypeId' . $i)) {
		
			$query = " UPDATE $DB_NAME.work_type 
						SET
							work_type_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'workTypeDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.work_type 
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

//-----------------------
//		MEASUREMENTS
//-----------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM $DB_NAME.measurements WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['measurementsArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.measurements VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['measurementsArray'][$recordType] as $key=>$value) {
	
		if ($key == $abbr.'measurementType' . $i) {
		
			$query = " UPDATE $DB_NAME.measurements 
						SET
							measurements_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
			
		
		} elseif (strstr($key, $abbr.'measurementField1_' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							measurements_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'commonMeasurementList1_' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							measurements_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'measurementField2_' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							measurements_text_2 = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'commonMeasurementList2_' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							measurements_unit_2 = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'inchesValue' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							inches_value = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'areaMeasurementList' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							area_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'days' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							duration_days = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'hours' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							duration_hours = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'minutes' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							duration_minutes = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
			
		
		} elseif (strstr($key, $abbr.'seconds' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							duration_seconds = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'fileSize' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							filesize_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'resolutionWidth' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							resolution_width = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'resolutionHeight' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							resolution_height = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'weightUnit' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							weight_unit = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			
		
		} elseif (strstr($key, $abbr.'otherMeasurementDescription' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements
						SET
							measurements_description = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'measurementDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.measurements 
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
	$query = " DELETE FROM $DB_NAME.culture WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['culturalContextArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.culture VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['culturalContextArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'culturalContext' . $i)) {
		
			$query = " UPDATE $DB_NAME.culture 
						SET
							culture_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'culturalContextId' . $i)) {
		
			$query = " UPDATE $DB_NAME.culture 
						SET
							culture_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'culturalContextDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.culture 
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
	$query = " DELETE FROM $DB_NAME.style_period WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['stylePeriodArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.style_period VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['stylePeriodArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'stylePeriod' . $i)) {
		
			$query = " UPDATE $DB_NAME.style_period 
						SET
							style_period_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'stylePeriodId' . $i)) {
		
			$query = " UPDATE $DB_NAME.style_period
						SET
							style_period_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'stylePeriodDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.style_period 
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
	$query = " DELETE FROM $DB_NAME.location WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['locationArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.location VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['locationArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'location' . $i)) {
		
			$query = " UPDATE $DB_NAME.location 
						SET
							location_text = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'locationId' . $i)) {
		
			$query = " UPDATE $DB_NAME.location
						SET
							location_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'locationNameType' . $i)) {
		
			$query = " UPDATE $DB_NAME.location
						SET
							location_name_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'locationType' . $i)) {
		
			$query = " UPDATE $DB_NAME.location
						SET
							location_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'locationDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.location 
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
//		SPECIFIC LOCATIONS
//---------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM $DB_NAME.specific_location WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['specificLocationArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.specific_location VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['specificLocationArray'][$recordType] as $key=>$value) {

		if (strstr($key, $abbr.'specificLocationType' . $i)) {

		
			$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'specificLocationAddress' . $i)) {
		
			$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_address = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'specificLocationZip' . $i)) {
		
			$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_zip = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'specificLocationLat' . $i)) {

			if (empty($value))
				{
					$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_lat = NULL
						WHERE
							id = '{$currentId}'";
					$result = db_query($mysqli, $query);
				}
				else
				{
					$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_lat = '{$value}'
						WHERE
							id = '{$currentId}'";
					$result = db_query($mysqli, $query);
				}
		}


		elseif (strstr($key, $abbr.'specificLocationLong' . $i)) {
		
				if (empty($value))
				{
					$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_long = NULL
						WHERE
							id = '{$currentId}'";
					$result = db_query($mysqli, $query);
				}
				else
				{
					$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_long = '{$value}'
						WHERE
							id = '{$currentId}'";
					$result = db_query($mysqli, $query);
				}
		}

		elseif (strstr($key, $abbr.'specificLocationNote' . $i)) {
		
			$query = " UPDATE $DB_NAME.specific_location
						SET
							specific_location_note = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		}
	
	}
	$i ++;
}


//---------------------
//	 BUILT WORK
//---------------------

if (!empty($recordNum) && $recordNum != '')

{
	$query = " DELETE FROM $DB_NAME.location 
					WHERE related_".$field_type."s = '{$recordNum}' 
					AND location_getty_id  REGEXP 'work' ";
	
	$result = db_query($mysqli, $query);
}
	
$i = 0;

while ($i < countCatRows($_SESSION['builtWorkArray'][$recordType])) {

			$sql = "INSERT INTO $DB_NAME.location VALUES () ";
			$res = db_query($mysqli, $sql);
			$currentId = $mysqli->insert_id;

		foreach ($_SESSION['builtWorkArray'][$recordType] as $key=>$value) {
			
			if (strstr($key, $abbr.'builtWork'. $i) && ($value == '')) {

				$sql = "DELETE FROM $DB_NAME.location  
							WHERE id = '{$currentId}' ";
					
					$res = db_query($mysqli, $sql);
					
				break; 
				continue;}	

				else if (strstr($key, $abbr.'builtWork'. $i)) {
				
					$query = " UPDATE $DB_NAME.location 
								SET
									location_text = '{$value}',
									related_".$field_type."s = '{$recordNum}'
								WHERE
									id = '{$currentId}'
							";
					$result = db_query($mysqli, $query);
					// echo $query.'<br>';
				}
			
				 else	if (strstr($key, $abbr.'builtWorkId'. $i)) {
				
					$query = " UPDATE $DB_NAME.location
								SET
									location_getty_id = '{$value}'
								WHERE
									id = '{$currentId}'
							";
					$result = db_query($mysqli, $query);
				
					} elseif (strstr($key, $abbr.'builtWorkNameType' . $i)) {
				
					$query = " UPDATE $DB_NAME.location
								SET
									location_name_type = '{$value}'
								WHERE
									id = '{$currentId}'
							";
					$result = db_query($mysqli, $query);
				
					} elseif (strstr($key, $abbr.'builtWorkType'. $i)) {
				
					$query = " UPDATE $DB_NAME.location
								SET
									location_type = '{$value}'
								WHERE
									id = '{$currentId}'
							";
					$result = db_query($mysqli, $query);
				
					} elseif (strstr($key, $abbr.'builtWorkDisplay'.$i)) {
				
					$query = " UPDATE $DB_NAME.location 
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
//		Relation
//---------------------

if ($recordType == 'work' || $recordType == 'createNewWork'){
	if (!empty($recordNum) && $recordNum != '')
	{
		$query = " DELETE FROM $DB_NAME.relation WHERE related_works = '{$recordNum}' ";

		$result = db_query($mysqli, $query);

		$query = " DELETE FROM $DB_NAME.relation WHERE relation_id = '{$recordNum}' ";

		$result = db_query($mysqli, $query);
	}

	$i = 0;

	while ($i < countCatRows($_SESSION['relationArray'][$recordType])) {

		$sql = "INSERT INTO $DB_NAME.relation VALUES () ";
		$res = db_query($mysqli, $sql);
		$currentId = $mysqli->insert_id;

		$sql = "INSERT INTO $DB_NAME.relation VALUES () ";
		$relRes = db_query($mysqli, $sql);
		$relationId = $mysqli->insert_id;

		foreach ($_SESSION['relationArray'][$recordType] as $key=>$value) {
		
			if (strstr($key, $abbr.'relationType' . $i)) {
			
				$query = " UPDATE $DB_NAME.relation
							SET
								relation_type = '{$value}',
								related_works = '{$recordNum}'
							WHERE
								id = '{$currentId}'
						";
				$result = db_query($mysqli, $query);
					
					switch ($value) {
					case '':
					$inverse = '';
					break;
					
					case 'relatedTo': $inverse = 'relatedTo'; break;
					case 'partOf': $inverse = 'largerContextFor'; break;
					case 'formerlyPartOf': $inverse  = 'formerlyLargerContextFor'; break;
					case 'componentOf': $inverse = 'componentIs'; break;
					case 'partnerInSetWith': $inverse  = 'partnerInSetWith'; break;
					case 'preparatoryFor': $inverse = 'basedOn'; break;
					case 'studyFor': $inverse = 'studyIs'; break;
					case 'cartoonFor': $inverse = 'cartoonIs'; break;
					case 'modelFor': $inverse = 'modelIs'; break;
					case 'planFor': $inverse = 'planIs'; break;
					case 'counterProofFor': $inverse = 'counterProofIs'; break;
					case 'printingPlateFor': $inverse = 'printingPlateIs'; break;
					case 'reliefFor': $inverse = 'impressionIs'; break;
					case 'prototypeFor': $inverse = 'prototypeIs'; break;
					case 'designedFor': $inverse = 'contextIs'; break;
					case 'mateOf': $inverse = 'mateOf'; break;
					case 'pendantOf': $inverse = 'pendantOf'; break;
					case 'exhibitedAt': $inverse = 'venueFor'; break;
					case 'copyAfter': $inverse = 'copyIs'; break;
					case 'depicts': $inverse = 'depictedIn'; break;
					case 'derivedFrom': $inverse = 'sourceFor'; break;
					case 'facsimileOf': $inverse = 'facsimileIs'; break;
					case 'replicaOf': $inverse = 'relplicaIs'; break;
					case 'versionOf': $inverse = 'versionIs'; break;
					case 'imageOf': $inverse = 'imageIs'; break;
					case 'largerContextFor': $inverse = 'partOf'; break;
					case 'formerlyLargerContextFor': $inverse = 'formerlyPartOf'; break;
					case 'componentIs': $inverse = 'componentOf'; break;
					case 'basedOn': $inverse = 'preparatoryFor'; break;
					case 'studyIs': $inverse = 'studyFor'; break;
					case 'cartoonIs': $inverse = 'cartoonFor'; break;
					case 'modelIs': $inverse = 'modelFor'; break;
					case 'planIs': $inverse = 'planFor'; break;
					case 'counterProofIs': $inverse = 'counterProofFor'; break;
					case 'printingPlateIs': $inverse = 'printingPlateFor'; break;
					case 'impressionIs': $inverse = 'reliefFor'; break;
					case 'prototypeIs': $inverse = 'prototypeFor'; break;
					case 'contextIs': $inverse = 'designedFor'; break;
					case 'venueFor': $inverse = 'exhibitedAt'; break;
					case 'copyIs': $inverse = 'copyAfter'; break;
					case 'depictedIn': $inverse = 'depicts'; break;
					case 'sourceFor': $inverse = 'derivedFrom'; break;
					case 'facsimileIs': $inverse = 'facsimileOf'; break;
					case 'relplicaIs': $inverse = 'replicaOf'; break;
					case 'versionIs': $inverse = 'versionOf'; break;
					case 'imageIs': $inverse = 'imageOf'; break;
				}		
				
			$query = " UPDATE $DB_NAME.relation 
						SET
						relation_type = '{$inverse}', 
						relation_id = '{$recordNum}' 
						WHERE id = '{$relationId}' ";

				$result = db_query($mysqli, $query);

			} elseif (strstr($key, $abbr.'relatedTo' . $i)) {
			
				$query = " UPDATE $DB_NAME.relation
							SET
								relation_id = '{$value}'
							WHERE
								id = '{$currentId}'
						";
				$result = db_query($mysqli, $query);			

				$query = " UPDATE $DB_NAME.relation
							SET related_works = '{$value}'
							WHERE id = '{$relationId}' ";

				$result = db_query($mysqli, $query);
			}
		
			$query = "DELETE FROM $DB_NAME.relation
						WHERE related_works = '{$value}'
						AND relation_type ='' ";

						$result = db_query($mysqli, $query);

		}

		$i ++;
	}
}

//--------------------------
//		STATE/EDITION
//--------------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM $DB_NAME.edition WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['stateEditionArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.edition VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['stateEditionArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'stateEditionType' . $i)) {
		
			$query = " UPDATE $DB_NAME.edition 
						SET
							edition_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'stateEdition' . $i)) {
		
			$query = " UPDATE $DB_NAME.edition
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

//------------------------
//		INSCRIPTIONS
//------------------------

if (!empty($recordNum) && $recordNum != '')
{
	$query = " DELETE FROM $DB_NAME.inscription WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['inscriptionArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.inscription VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['inscriptionArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'inscriptionType' . $i)) {
		
			$query = " UPDATE $DB_NAME.inscription 
						SET
							inscription_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'workInscription' . $i)) {
		
			$query = " UPDATE $DB_NAME.inscription
						SET
							inscription_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'workInscriptionAuthor' . $i)) {
		
			$query = " UPDATE $DB_NAME.inscription
						SET
							inscription_author = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'workInscriptionLocation' . $i)) {
		
			$query = " UPDATE $DB_NAME.inscription
						SET
							inscription_location = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'inscriptionDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.inscription 
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
	$query = " DELETE FROM $DB_NAME.subject WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['subjectArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.subject VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['subjectArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'subjectType' . $i)) {
		
			$query = " UPDATE $DB_NAME.subject 
						SET
							subject_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'subject' . $i)) {
		
			$query = " UPDATE $DB_NAME.subject
						SET
							subject_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'subjectId' . $i)) {
		
			$query = " UPDATE $DB_NAME.subject
						SET
							subject_getty_id = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'subjectDisplay' . $i)) {
		
			$query = " UPDATE $DB_NAME.subject 
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
	$query = " DELETE FROM $DB_NAME.rights WHERE related_".$field_type."s = '{$recordNum}' ";
	$result = db_query($mysqli, $query);
}

$i = 0;

while ($i < countCatRows($_SESSION['rightsArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.rights VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['rightsArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'rightsType' . $i)) {
		
			$query = " UPDATE $DB_NAME.rights 
						SET
							rights_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'rightsHolder' . $i)) {
		
			$query = " UPDATE $DB_NAME.rights
						SET
							rights_holder = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'rightsText' . $i)) {
		
			$query = " UPDATE $DB_NAME.rights
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
	$query = isnerQ("DELETE FROM $DB_NAME.source WHERE related_".$field_type."s = '{$recordNum}'");
}

$i = 0;

while ($i < countCatRows($_SESSION['sourceArray'][$recordType])) {

	$sql = "INSERT INTO $DB_NAME.source VALUES () ";
	$res = db_query($mysqli, $sql);
	$currentId = $mysqli->insert_id;

	foreach ($_SESSION['sourceArray'][$recordType] as $key=>$value) {
	
		if (strstr($key, $abbr.'sourceNameType' . $i)) {
		
			$query = " UPDATE $DB_NAME.source 
						SET
							source_name_type = '{$value}',
							related_".$field_type."s = '{$recordNum}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
			// echo $query.'<br>';
		
		} elseif (strstr($key, $abbr.'sourceName' . $i)) {
		
			$query = " UPDATE $DB_NAME.source
						SET
							source_name_text = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'sourceType' . $i)) {
		
			$query = " UPDATE $DB_NAME.source
						SET
							source_type = '{$value}'
						WHERE
							id = '{$currentId}'
					";
			$result = db_query($mysqli, $query);
		
		} elseif (strstr($key, $abbr.'source' . $i)) {
		
			$query = " UPDATE $DB_NAME.source
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