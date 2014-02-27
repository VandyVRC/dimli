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
	$_SESSION['workNum'] = 
		(!empty($row['related_works']))
			? $row['related_works']
			: 'None';
}

// Initialize SESSION work array and variables for cataloging input elements

$_SESSION['work'] = array();

$_SESSION['work']['titleType0'] = $Wtitle[0]['titleType'] =
$_SESSION['work']['title0'] = $Wtitle[0]['title'] =
$_SESSION['work']['agentAttribution0'] = $Wagent[0]['agentAttribution'] =
$_SESSION['work']['agent0'] = $Wagent[0]['agent'] =
$_SESSION['work']['agentType0'] = $Wagent[0]['agentType'] =
$_SESSION['work']['agentRole0'] = $Wagent[0]['agentRole'] =
$_SESSION['work']['agentId0'] = $Wagent[0]['agentId'] =
$_SESSION['work']['dateType0'] = $Wdate[0]['dateType'] =
$_SESSION['work']['dateRange0'] = $Wdate[0]['dateRange'] =
$_SESSION['work']['circaDate0'] = $Wdate[0]['circaDate'] =
$_SESSION['work']['startDate0'] = $Wdate[0]['startDate'] =
$_SESSION['work']['startDateEra0'] = $Wdate[0]['startDateEra'] =
$_SESSION['work']['endDate0'] = $Wdate[0]['endDate'] =
$_SESSION['work']['endDateEra0'] = $Wdate[0]['endDateEra'] =
$_SESSION['work']['materialType0'] = $Wmaterial[0]['materialType'] =
$_SESSION['work']['material0'] = $Wmaterial[0]['material'] =
$_SESSION['work']['materialId0'] = $Wmaterial[0]['materialId'] =
$_SESSION['work']['technique0'] = $Wtechnique[0]['technique'] =
$_SESSION['work']['techniqueId0'] = $Wtechnique[0]['techniqueId'] =
$_SESSION['work']['workType0'] = $WworkType[0]['workType'] =
$_SESSION['work']['workTypeId0'] = $WworkType[0]['workTypeId'] =
$_SESSION['work']['culturalContext0'] = $WculturalContext[0]['culturalContext'] =
$_SESSION['work']['culturalContextId0'] = $WculturalContext[0]['culturalContextId'] =
$_SESSION['work']['stylePeriod0'] = $WstylePeriod[0]['stylePeriod'] =
$_SESSION['work']['stylePeriodId0'] = $WstylePeriod[0]['stylePeriodId'] =
$_SESSION['work']['location0'] = $Wlocation[0]['location'] =
$_SESSION['work']['locationId0'] = $Wlocation[0]['locationId'] =
$_SESSION['work']['locationNameType0'] = $Wlocation[0]['locationNameType'] =
$_SESSION['work']['locationType0'] = $Wlocation[0]['locationType'] =
$_SESSION['work']['description0'] = $Wdescription =
$_SESSION['work']['stateEditionType0'] = $WstateEdition[0]['stateEditionType'] =
$_SESSION['work']['stateEdition0'] = $WstateEdition[0]['stateEdition'] =
$_SESSION['work']['measurementType0'] = $Wmeasurements[0]['measurementType'] =
$_SESSION['work']['measurementField1_0'] = $Wmeasurements[0]['measurementField1_'] =
$_SESSION['work']['commonMeasurementList1_0'] = $Wmeasurements[0]['commonMeasurementList1_'] =
$_SESSION['work']['measurementField2_0'] = $Wmeasurements[0]['measurementField2_'] =
$_SESSION['work']['commonMeasurementList2_0'] = $Wmeasurements[0]['commonMeasurementList2_'] =
$_SESSION['work']['inchesValue0'] = $Wmeasurements[0]['inchesValue'] =
$_SESSION['work']['areaMeasurementList0'] = $Wmeasurements[0]['areaMeasurementList'] =
$_SESSION['work']['days0'] = $Wmeasurements[0]['days'] =
$_SESSION['work']['hours0'] = $Wmeasurements[0]['hours'] =
$_SESSION['work']['minutes0'] = $Wmeasurements[0]['minutes'] =
$_SESSION['work']['seconds0'] = $Wmeasurements[0]['seconds'] =
$_SESSION['work']['fileSize0'] = $Wmeasurements[0]['fileSize'] =
$_SESSION['work']['resolutionWidth0'] = $Wmeasurements[0]['resolutionWidth'] =
$_SESSION['work']['resolutionHeight0'] = $Wmeasurements[0]['resolutionHeight'] =
$_SESSION['work']['weightUnit0'] = $Wmeasurements[0]['weightUnit'] =
$_SESSION['work']['otherMeasurementDescription0'] = $Wmeasurements[0]['otherMeasurementDescription'] =
$_SESSION['work']['subjectType0'] = $Wsubject[0]['subjectType'] =
$_SESSION['work']['subject0'] = $Wsubject[0]['subject'] =
$_SESSION['work']['subjectId0'] = $Wsubject[0]['subjectId'] =
$_SESSION['work']['inscriptionType0'] = $Winscription[0]['inscriptionType'] =
$_SESSION['work']['workInscription0'] = $Winscription[0]['workInscription'] =
$_SESSION['work']['workInscriptionAuthor0'] = $Winscription[0]['workInscriptionAuthor'] =
$_SESSION['work']['workInscriptionLocation0'] = $Winscription[0]['workInscriptionLocation'] =
$_SESSION['work']['rightsType0'] = $Wrights[0]['rightsType'] =
$_SESSION['work']['rightsHolder0'] = $Wrights[0]['rightsHolder'] =
$_SESSION['work']['rightsText0'] = $Wrights[0]['rightsText'] =
$_SESSION['work']['sourceNameType0'] = $Wsource[0]['sourceNameType'] =
$_SESSION['work']['sourceName0'] = $Wsource[0]['sourceName'] =
$_SESSION['work']['sourceType0'] = $Wsource[0]['sourceType'] =
$_SESSION['work']['source0'] = $Wsource[0]['source'] =
$_SESSION['work']['updated'] = '';


if ($_SESSION['workNum'] != 'None')
// There IS a related work in the image record
// Retrieve info about the work
{
	//-------------
	//  Log visit
	//-------------

	$UnixTime = time(TRUE);

	$sql = "INSERT INTO $DB_NAME.activity 
				SET UserID = '{$_SESSION['user_id']}', 
					RecordType = 'Work', 
					RecordNumber = {$_SESSION['workNum']}, 
					ActivityType = 'viewed', 
					UnixTime = '{$UnixTime}' ";

	$result = db_query($mysqli, $sql);

	// -----------
	//	Updated
	// -----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.work 
				WHERE id = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['updated'] = 'Updated: ' . date('D, M j, Y - h:i a', strtotime($row['last_update'])) . ' by '. $row['last_update_by'];
	}
	
	// -----------
	//	Title
	// -----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.title 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['titleType'.$i] = $Wtitle[$i]['titleType'] = $row['title_type'];
		$_SESSION['work']['title'.$i] = $Wtitle[$i]['title'] = $row['title_text'];
		$_SESSION['work']['titleDisplay'.$i] = $Wtitle[$i]['titleDisplay'] = $row['display'];
		$i ++;
	}
	
	// ----------
	//	Agent
	// ----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.agent 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['agentAttribution'.$i] = $Wagent[$i]['agentAttribution'] = $row['agent_attribution'];
		$_SESSION['work']['agent'.$i] = $Wagent[$i]['agent'] = $row['agent_text'];
		$_SESSION['work']['agentType'.$i] = $Wagent[$i]['agentType'] = $row['agent_type'];
		$_SESSION['work']['agentRole'.$i] = $Wagent[$i]['agentRole'] = $row['agent_role'];
		$_SESSION['work']['agentId'.$i] = $Wagent[$i]['agentId'] = $row['agent_getty_id'];
		$_SESSION['work']['agentDisplay'.$i] = $Wtitle[$i]['agentDisplay'] = $row['display'];
		$i ++;
	}
	
	// ----------
	//	Date
	// ----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.date 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['dateType'.$i] = $Wdate[$i]['dateType'] = $row['date_type'];
		$_SESSION['work']['dateRange'.$i] = $Wdate[$i]['dateRange'] = $row['date_range'];
		$_SESSION['work']['circaDate'.$i] = $Wdate[$i]['circaDate'] = $row['date_circa'];
		$_SESSION['work']['startDate'.$i] = $Wdate[$i]['startDate'] = $row['date_text'];
		$_SESSION['work']['startDateEra'.$i] = $Wdate[$i]['startDateEra'] = $row['date_era'];
		$_SESSION['work']['endDate'.$i] = $Wdate[$i]['endDate'] = $row['enddate_text'];
		$_SESSION['work']['endDateEra'.$i] = $Wdate[$i]['endDateEra'] = $row['enddate_era'];
		$_SESSION['work']['dateDisplay'.$i] = $Wtitle[$i]['dateDisplay'] = $row['display'];
		$i ++;
	}
	
	// --------------
	//	Material
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.material 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['materialType'.$i] = $Wmaterial[$i]['materialType'] = $row['material_type'];
		$_SESSION['work']['material'.$i] = $Wmaterial[$i]['material'] = $row['material_text'];
		$_SESSION['work']['materialId'.$i] = $Wmaterial[$i]['materialId'] = $row['material_getty_id'];
		$_SESSION['work']['materialDisplay'.$i] = $Wtitle[$i]['materialDisplay'] = $row['display'];
		$i ++;
	}
	
	// ---------------
	//	Technique
	// ---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.technique 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['technique'.$i] = $Wtechnique[$i]['technique'] = $row['technique_text'];
		$_SESSION['work']['techniqueId'.$i] = $Wtechnique[$i]['techniqueId'] = $row['technique_getty_id'];
		$_SESSION['work']['techniqueDisplay'.$i] = $Wtitle[$i]['techniqueDisplay'] = $row['display'];
		$i ++;
	}
	
	// ---------------
	//	Work Type
	// ---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.work_type 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['workType'.$i] = $WworkType[$i]['workType'] = $row['work_type_text'];
		$_SESSION['work']['workTypeId'.$i] = $WworkType[$i]['workTypeId'] = $row['work_type_getty_id'];
		$_SESSION['work']['workTypeDisplay'.$i] = $Wtitle[$i]['workTypeDisplay'] = $row['display'];
		$i ++;
	}
	
	// ----------------------
	//	Cultural Context
	// ----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.culture 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['culturalContext'.$i] = $WculturalContext[$i]['culturalContext'] = $row['culture_text'];
		$_SESSION['work']['culturalContextId'.$i] = $WculturalContext[$i]['culturalContextId'] = $row['culture_getty_id'];
		$_SESSION['work']['culturalContextDisplay'.$i] = $Wtitle[$i]['culturalContextDisplay'] = $row['display'];
		$i ++;
	}
	
	// ------------------
	//	Style Period
	// ------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.style_period 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['stylePeriod'.$i] = $WstylePeriod[$i]['stylePeriod'] = $row['style_period_text'];
		$_SESSION['work']['stylePeriodId'.$i] = $WstylePeriod[$i]['stylePeriodId'] = $row['style_period_getty_id'];
		$_SESSION['work']['stylePeriodDisplay'.$i] = $Wtitle[$i]['stylePeriodDisplay'] = $row['display'];
		$i ++;
	}
	
	// -------------
	//	Location
	// -------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.location 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['location'.$i] = $Wlocation[$i]['location'] = $row['location_text'];
		$_SESSION['work']['locationId'.$i] = $Wlocation[$i]['locationId'] = $row['location_getty_id'];
		$_SESSION['work']['locationNameType'.$i] = $Wlocation[$i]['locationNameType'] = $row['location_name_type'];
		$_SESSION['work']['locationType'.$i] = $Wlocation[$i]['locationType'] = $row['location_type'];
		$_SESSION['work']['locationDisplay'.$i] = $Wtitle[$i]['locationDisplay'] = $row['display'];
		$i ++;
	}
	
	// -----------------
	//	Description
	// -----------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.work 
				WHERE id = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['description0'] = $Wdescription0 = $row['description'];
	}
	
	// -------------------
	//	State/Edition
	// -------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.edition 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['stateEditionType'.$i] = $WstateEdition[$i]['stateEditionType'] = $row['edition_type'];
		$_SESSION['work']['stateEdition'.$i] = $WstateEdition[$i]['stateEdition'] = $row['edition_text'];
		$i ++;
	}
	
	// -------------------
	//	Measurements
	// -------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.measurements 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['measurementType'.$i] = $Wmeasurements[$i]['measurementType'] = $row['measurements_type'];
		$_SESSION['work']['measurementField1_'.$i] = $Wmeasurements[$i]['measurementField1_'] = $row['measurements_text'];
		$_SESSION['work']['commonMeasurementList1_'.$i] = $Wmeasurements[$i]['commonMeasurementList1_'] = $row['measurements_unit'];
		$_SESSION['work']['measurementField2_'.$i] = $Wmeasurements[$i]['measurementField2_'] = $row['measurements_text_2'];
		$_SESSION['work']['commonMeasurementList2_'.$i] = $Wmeasurements[$i]['commonMeasurementList2_'] = $row['measurements_unit_2'];
		$_SESSION['work']['inchesValue'.$i] = $Wmeasurements[$i]['inchesValue'] = $row['inches_value'];
		$_SESSION['work']['areaMeasurementList'.$i] = $Wmeasurements[$i]['areaMeasurementList'] = $row['area_unit'];
		$_SESSION['work']['days'.$i] = $Wmeasurements[$i]['days'] = $row['duration_days'];
		$_SESSION['work']['hours'.$i] = $Wmeasurements[$i]['hours'] = $row['duration_hours'];
		$_SESSION['work']['minutes'.$i] = $Wmeasurements[$i]['minutes'] = $row['duration_minutes'];
		$_SESSION['work']['seconds'.$i] = $Wmeasurements[$i]['seconds'] = $row['duration_seconds'];
		$_SESSION['work']['fileSize'.$i] = $Wmeasurements[$i]['fileSize'] = $row['filesize_unit'];
		$_SESSION['work']['resolutionWidth'.$i] = $Wmeasurements[$i]['resolutionWidth'] = $row['resolution_width'];
		$_SESSION['work']['resolutionHeight'.$i] = $Wmeasurements[$i]['resolutionHeight'] = $row['resolution_height'];
		$_SESSION['work']['weightUnit'.$i] = $Wmeasurements[$i]['weightUnit'] = $row['weight_unit'];
		$_SESSION['work']['otherMeasurementDescription'.$i] = $Wmeasurements[$i]['otherMeasurementDescription'] = $row['measurements_description'];
		$_SESSION['work']['measurementDisplay'.$i] = $Wtitle[$i]['measurementDisplay'] = $row['display'];
		$i ++;
	}
	
	// --------------
	//	Subject
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.subject 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['subjectType'.$i] = $Wsubject[$i]['subjectType'] = $row['subject_type'];
		$_SESSION['work']['subject'.$i] = $Wsubject[$i]['subject'] = $row['subject_text'];
		$_SESSION['work']['subjectId'.$i] = $Wsubject[$i]['subjectId'] = $row['subject_getty_id'];
		$_SESSION['work']['subjectDisplay'.$i] = $Wtitle[$i]['subjectDisplay'] = $row['display'];
		$i ++;
	}
	
	// -----------------
	//	Inscription
	// -----------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.inscription 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['inscriptionType'.$i] = $Winscription[$i]['inscriptionType'] = $row['inscription_type'];
		$_SESSION['work']['workInscription'.$i] = $Winscription[$i]['workInscription'] = $row['inscription_text'];
		$_SESSION['work']['workInscriptionAuthor'.$i] = $Winscription[$i]['workInscriptionAuthor'] = $row['inscription_author'];
		$_SESSION['work']['workInscriptionLocation'.$i] = $Winscription[$i]['workInscriptionLocation'] = $row['inscription_location'];
		$_SESSION['work']['inscriptionDisplay'.$i] = $Wtitle[$i]['inscriptionDisplay'] = $row['display'];
		$i ++;
	}
	
	// --------------
	//	Rights
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.rights 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['rightsType'.$i] = $Wrights[$i]['rightsType'] = $row['rights_type'];
		$_SESSION['work']['rightsHolder'.$i] = $Wrights[$i]['rightsHolder'] = $row['rights_holder'];
		$_SESSION['work']['rightsText'.$i] = $Wrights[$i]['rightsText'] = $row['rights_text'];
		$i ++;
	}
	
	// --------------
	//	Source (Work)
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.source 
				WHERE related_works = '{$_SESSION['workNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['work']['sourceNameType'.$i] = $Wsource[$i]['sourceNameType'] = $row['source_name_type'];
		$_SESSION['work']['sourceName'.$i] = $Wsource[$i]['sourceName'] = $row['source_name_text'];
		$_SESSION['work']['sourceType'.$i] = $Wsource[$i]['sourceType'] = $row['source_type'];
		$_SESSION['work']['source'.$i] = $Wsource[$i]['source'] = $row['source_text'];
		$i ++;
	}
	
}
elseif ($_SESSION['workNum'] == 'None')
// There is NO WORK associated with the selected image
{

	$_SESSION['workAssoc_search'] = array('title'=>'', 'agent'=>'');

}
	
include('../_php/_order/query_work.php'); ?>

<script>

	var workNum = $.trim(<?php echo json_encode($_SESSION['workNum']); ?>);
	// console.log(workNum+' added to the header of the work record'); // Debug
	$('div#work_module h1').append('<div class="floatRight">' + workNum + '</div>');

</script>

<div class="workRecord_catalogInfo">
						
	<?php
	if ($_SESSION['workNum']=='None') 
	// An associated work record DOES NOT EXIST for the current image
	{
		if ($_SESSION['priv_catalog']=='1')
		{ ?>

			<div id="workAssoc_wrapper">

				<p id="noAssocWork" 
					class="mediumWeight" 
					style="text-align: center; margin: 35px 0 35px 0; font-size: 1.5em; color: #CCC;"
					>No associated work record</p>

				<div id="workAssoc_searchFields">

					<p>a) Use an existing work:</p>

					<input type="text" 
						name="title"
						placeholder="Title"
						value="<?php echo $_SESSION['workAssoc_search']['title']; ?>">

					<script>$('input[name=title]').focus();</script>

					<br>

					<input type="text" 
						name="agent"
						placeholder="Agent"
						value="<?php echo $_SESSION['workAssoc_search']['title']; ?>">

					<br>

					<input type="button"
						id="workAssoc_search_submit_button"
						value="Search">

				</div>

				<div id="workAssoc_createNew">

					<p>b) Create a new work:</p>

					<input type="button"
						id="workRecord_newCata"
						value="Catalog">

				</div>

			</div>

		<?php
		}
		else
		{ ?>

			<div id="workAssoc_wrapper">

				<p id="noAssocWork" 
					class="mediumWeight" 
					style="text-align: center; margin: 35px 0 35px 0; font-size: 1.5em; color: #CCC;"
					>No associated work record<br>Ask a cataloger to help rectify this!</p>

			</div>

		<?php
		}
	} 
	elseif ($_SESSION['workNum'] != 'None')
	// An associated work record DOES EXIST for the current image
	{ ?>

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

		<?php if ($_SESSION['priv_catalog'] == '1') { ?>

			<a id="workAssoc_remove" 
				title="Break work association">

				<img src="_assets/_images/link_break.png" 
					style="height: 20px; width: 20px;">

			</a>

		<?php } ?>

	</div>

	<!-- 
		THUMBNAIL PREVIEW
	 -->

	<div class="workRecord_thumb"
		style="position: absolute; top: 0; right: 0;">

		<?php
		
		if (isset($prefLegId) && !in_array($work_thumb_id, array('','0')) && checkRemoteFile($IMAGE_DIR.'thumb/'.$prefLegId.'.jpg')) {
		// IF a preferred image is assigned for this work record
		?>

		<img class="catThumb" src="<?php echo $work_thumb_file; ?>"
			onclick="image_viewer('<?php echo $prefLegId; ?>');">

		<?php
		}

		else if ($_SESSION['workNum'] != 'None' &&
 -			$_SESSION['workNum'] != '')
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
		Description
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Description:</div>

		<div class="content_lineText"><?php
			echo (!empty($workDescription)) ? $workDescription : '--';
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
		Rights
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Rights:</div>

		<div class="content_lineText"><?php
			if (!empty($workRights)) { foreach ($workRights as $rights) { echo $rights . '<br>'; } }
		?></div>

	</div>
	
	<!--
		Sources
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Source:</div>

		<div class="content_lineText"><?php
			if (!empty($workSources)) { foreach ($workSources as $source) { echo $source . '<br>'; } }
		?></div>

	</div>

	<?php } ?>

</div>

<!-- 
	Module Footer
 -->

<?php 
if (isset($associatedImages_ct) && $associatedImages_ct > 0)
{
?>

<div class="module_footer defaultCursor">

	<div id="module_footer_title"
		title="View associated image records">

		This work has&nbsp;<span class="mediumWeight"><?php echo $associatedImages_ct; ?></span>&nbsp;child&nbsp;<?php echo($associatedImages_ct == 1)?'image':'images'; ?><span class="arrow down">&#9660;</span>

	</div>

	<!-- 
		Associated Images List
	 -->

	<div id="work_assocImages">

		<?php while ($row = $result_assocImages->fetch_assoc())
		// Iterate results from query performed in 
		// "_php/_order/query_work.php"
		{

			$assocImg_id = create_six_digits($row['id']);

			$assocImg_legId = $row['legacy_id'];

			$truncView = (strlen($assocImg_legId) > 6) 
    				? substr($assocImg_legId, 0, 6) . '...' 
   				: $assocImg_legId;

			$assocImg_file = $webroot."/_plugins/timthumb/timthumb.php?src=".$image_src."medium/".$assocImg_legId.".jpg&amp;h=40&amp;w=53&amp;q=90";


			$sql = "SELECT order_id 
						FROM $DB_NAME.image 
						WHERE id = '{$row['id']}' ";

			$assocImg_order_res = db_query($mysqli, $sql);

			while ($order = $assocImg_order_res->fetch_assoc())
			{
				$assocImg_order = $order['order_id'];
			}

			$sql = "SELECT title_text 
						FROM $DB_NAME.title 
						WHERE related_images = '{$assocImg_id}' ";

			$assocImg_title_res = db_query($mysqli, $sql);

			$assocImg_title_arr = array();

			while ($title = $assocImg_title_res->fetch_assoc())
			{
				$assocImg_title_arr[] = $title['title_text'];
			} ?>

			<div class="work_assocImage_row">

				<div class="assocImage_order"
					style="display: none;"><?php echo $assocImg_order; ?></div>

				<div class="assocImage_jump"
					style="display: none;"><?php echo $assocImg_id; ?></div>	

				<div class="assocImage_view"
					style="display: none;"><?php echo $assocImg_legId; ?></div>	
				
				<div class="purple mediumWeight"
					style="width: 50px; padding-right: 5px;">

					<a class="assocImage_open"
						title="Jump to record"><?php echo $truncView; ?></a>

				</div>

				<div style="padding-right: 5px;">

					<img class="assocImage_preview"
						src="<?php echo $assocImg_file; ?>"
						title="Click to preview"
						style="max-height: 40px; max-width: 53px;">

				</div>

				<div style="display: inline-block; width: 290px; padding-right: 5px;">

					<?php foreach ($assocImg_title_arr as $title)
					{
						echo '<div class="assocImage_title">'.$title.'</div>';
					}
					?>

				</div>

				<div class="assocImage_pref pointer"
					title="Set as preferred image"></div>

			</div>

		<?php
		}
		?>

	</div>

</div>

<?php
}
?>

<script>

	/*
	Break Work and Image association
	*/
	$('a#workAssoc_remove').click(
		function()
		{
			if (confirm('Are you sure you wish to break the association between the current work and image records?'))
			{
				remove_work_assoc(
					"<?php echo (isset($_SESSION['order'])) ? $_SESSION['order']:'None';?>",
					"<?php echo $_SESSION['workNum'];?>",
					"<?php echo $_SESSION['imageNum'];?>"
					);
			}
		});


	// NO associated work: Hide catalog info
	var workNum = "<?php echo $_SESSION['workNum'];?>";
	if (workNum == 'None')
	{
		$('div.workRecord_thumb')
			.add('div#work_module div.record_updateInfo')
			.add('div#work_module div.content_line')
			.hide();
	}

	// User clicks Catalog: Show cataloging interface
	$('input#workRecord_newCata').click(function()
	{
		$('div#workAssoc_wrapper').hide();
		$('div#workAssoc_results').remove();
		$('div.workRecord_thumb')
			.add('div#work_module div.record_updateInfo')
			.add('div#work_module div.content_line')
			.show();
		catalog_work();
		catalog_image();
	});

	$(document).ready(function()
	{
		$('input[name=title]').focus().val('');
	});
	
	function workAssoc_submit()
	{
		var titleTerm = $('div#workAssoc_searchFields input[name=title]').val();
		var agentTerm = $('div#workAssoc_searchFields input[name=agent]').val();
		workAssoc_search(titleTerm, agentTerm);
	}


	// SEARCH FOR EXISTING WORK RECORDS

	$('input#workAssoc_search_submit_button').click(workAssoc_submit);

	$('div#workAssoc_searchFields input').keypress(function(e)
	{
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13))
		{
			workAssoc_submit();
		}
	});


	// TOGGLE ASSOCIATED IMAGES FOOTER

	$('div#work_module div#module_footer_title').click(
		function(event)
		{
			$('div#work_assocImages').slideToggle(400);

			// Toggle expand/collapse arrow
			var arrow = $(this).find('span.arrow');
			if ($(arrow).hasClass('down'))
			{
				$(this).find('span.arrow').html('&#9650;');
				$(this).find('span.arrow').removeClass('down');
			}
			else
			{
				$(this).find('span.arrow').html('&#9660;');
				$(this).find('span.arrow').addClass('down');
			}

			event.preventDefault();
		});


	// JUMP TO ASSOCIATED IMAGE RECORD

	$('a.assocImage_open').click(
		function()
		{
			var order = $(this).parents('div.work_assocImage_row')
								.find('div.assocImage_order')
								.text();
			open_order(order);

			var imageNum = $(this).parents('div.work_assocImage_row')
								.find('div.assocImage_jump')
								.text();
			view_image_record(imageNum);
			view_work_record(imageNum);
		});


	// ASSOCIATED IMAGE PREVIEW

	$('img.assocImage_preview').click(
		function()
		{
			var image = $(this).parents('div.work_assocImage_row')
								.find('div.assocImage_view')
								.text();
			image_viewer(image);
		});

	
	// HIGHLIGHT PREFERRED ASSOCIATED IMAGE CHECKBOX

	$('div.assocImage_pref').each(
		function()
		{
			var image = $(this).parents('div.work_assocImage_row')
								.find('div.assocImage_jump')
								.text();
			var pref_image = '<?php echo $work_thumb_id;?>';
			if (image == pref_image)
			{
				$(this).addClass('pref');
			}
		});


	// ASSIGN NEW PREFERRED ASSOCIATED IMAGE

	$('div.assocImage_pref:not(.pref)').click(
		function()
		{
			var image = $(this).parents('div.work_assocImage_row')
								.find('div.assocImage_jump')
								.text();
			work_assign_preview(
				image, 
				'<?php echo $_SESSION['workNum'];?>'
				);
			$('div.assocImage_pref').removeClass('pref');
			$(this).addClass('pref');
		});

</script>

