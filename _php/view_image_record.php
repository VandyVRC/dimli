<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_orders_read');

if (isset($_GET['imageRecord']))
{
	$_SESSION['imageNum'] = $_GET['imageRecord'];

	$sql = "SELECT related_works, 
					order_id 
				FROM $DB_NAME.image 
				WHERE id = {$_SESSION['imageNum']} ";

	$result = db_query($mysqli, $sql);

	while ($row = $result->fetch_assoc())
	{ 
		$_SESSION['workNum'] = $row['related_works'];
		$_SESSION['order'] = $row['order_id'];
	}
	
	//-------------
	//  Log visit
	//-------------

	$UnixTime = time(TRUE);

	$sql = "INSERT INTO $DB_NAME.activity 
				SET UserID = '{$_SESSION['user_id']}', 
					RecordType = 'Image', 
					RecordNumber = {$_SESSION['imageNum']}, 
					ActivityType = 'viewed', 
					UnixTime = '{$UnixTime}' ";

	$result = db_query($mysqli, $sql);

	$_SESSION['image'] = array();
	
	$_SESSION['image']['titleType0'] = $Ititle[0]['titleType'] =
	$_SESSION['image']['title0'] = $Ititle[0]['title'] =
	$_SESSION['image']['agentAttribution0'] = $Iagent[0]['agentAttribution'] =
	$_SESSION['image']['agent0'] = $Iagent[0]['agent'] =
	$_SESSION['image']['agentType0'] = $Iagent[0]['agentType'] =
	$_SESSION['image']['agentRole0'] = $Iagent[0]['agentRole'] =
	$_SESSION['image']['agentId0'] = $Iagent[0]['agentId'] =
	$_SESSION['image']['dateType0'] = $Idate[0]['dateType'] =
	$_SESSION['image']['dateRange0'] = $Idate[0]['dateRange'] =
	$_SESSION['image']['circaDate0'] = $Idate[0]['circaDate'] =
	$_SESSION['image']['startDate0'] = $Idate[0]['startDate'] =
	$_SESSION['image']['startDateEra0'] = $Idate[0]['startDateEra'] =
	$_SESSION['image']['endDate0'] = $Idate[0]['endDate'] =
	$_SESSION['image']['endDateEra0'] = $Idate[0]['endDateEra'] =
	$_SESSION['image']['materialType0'] = $Imaterial[0]['materialType'] =
	$_SESSION['image']['material0'] = $Imaterial[0]['material'] =
	$_SESSION['image']['materialId0'] = $Imaterial[0]['materialId'] =
	$_SESSION['image']['technique0'] = $Itechnique[0]['technique'] =
	$_SESSION['image']['techniqueId0'] = $Itechnique[0]['techniqueId'] =
	$_SESSION['image']['workType0'] = $IworkType[0]['workType'] =
	$_SESSION['image']['workTypeId0'] = $IworkType[0]['workTypeId'] =
	$_SESSION['image']['culturalContext0'] = $IculturalContext[0]['culturalContext'] =
	$_SESSION['image']['culturalContextId0'] = $IculturalContext[0]['culturalContextId'] =
	$_SESSION['image']['stylePeriod0'] = $IstylePeriod[0]['stylePeriod'] =
	$_SESSION['image']['stylePeriodId0'] = $IstylePeriod[0]['stylePeriodId'] =
	$_SESSION['image']['location0'] = $Ilocation[0]['location'] =
	$_SESSION['image']['locationId0'] = $Ilocation[0]['locationId'] =
	$_SESSION['image']['locationNameType0'] = $Ilocation[0]['locationNameType'] =
	$_SESSION['image']['locationType0'] = $Ilocation[0]['locationType'] =
	$_SESSION['image']['description0'] = $Idescription =
	$_SESSION['image']['stateEditionType0'] = $IstateEdition[0]['stateEditionType'] =
	$_SESSION['image']['stateEdition0'] = $IstateEdition[0]['stateEdition'] =
	$_SESSION['image']['measurementType0'] = $Imeasurements[0]['measurementType'] =
	$_SESSION['image']['measurementField1_0'] = $Imeasurements[0]['measurementField1_'] =
	$_SESSION['image']['commonMeasurementList1_0'] = $Imeasurements[0]['commonMeasurementList1_'] =
	$_SESSION['image']['measurementField2_0'] = $Imeasurements[0]['measurementField2_'] =
	$_SESSION['image']['commonMeasurementList2_0'] = $Imeasurements[0]['commonMeasurementList2_'] =
	$_SESSION['image']['inchesValue0'] = $Imeasurements[0]['inchesValue'] =
	$_SESSION['image']['areaMeasurementList0'] = $Imeasurements[0]['areaMeasurementList'] =
	$_SESSION['image']['days0'] = $Imeasurements[0]['days'] =
	$_SESSION['image']['hours0'] = $Imeasurements[0]['hours'] =
	$_SESSION['image']['minutes0'] = $Imeasurements[0]['minutes'] =
	$_SESSION['image']['seconds0'] = $Imeasurements[0]['seconds'] =
	$_SESSION['image']['fileSize0'] = $Imeasurements[0]['fileSize'] =
	$_SESSION['image']['resolutionWidth0'] = $Imeasurements[0]['resolutionWidth'] =
	$_SESSION['image']['resolutionHeight0'] = $Imeasurements[0]['resolutionHeight'] =
	$_SESSION['image']['weightUnit0'] = $Imeasurements[0]['weightUnit'] =
	$_SESSION['image']['otherMeasurementDescription0'] = $Imeasurements[0]['otherMeasurementDescription'] =
	$_SESSION['image']['subjectType0'] = $Isubject[0]['subjectType'] =
	$_SESSION['image']['subject0'] = $Isubject[0]['subject'] =
	$_SESSION['image']['subjectId0'] = $Isubject[0]['subjectId'] =
	$_SESSION['image']['inscriptionType0'] = $Iinscription[0]['inscriptionType'] =
	$_SESSION['image']['workInscription0'] = $Iinscription[0]['workInscription'] =
	$_SESSION['image']['workInscriptionAuthor0'] = $Iinscription[0]['workInscriptionAuthor'] =
	$_SESSION['image']['workInscriptionLocation0'] = $Iinscription[0]['workInscriptionLocation'] =
	$_SESSION['image']['rightsType0'] = $Irights[0]['rightsType'] =
	$_SESSION['image']['rightsHolder0'] = $Irights[0]['rightsHolder'] =
	$_SESSION['image']['rightsText0'] = $Irights[0]['rightsText'] =
	$_SESSION['image']['sourceNameType0'] = $Isource[0]['sourceNameType'] =
	$_SESSION['image']['sourceName0'] = $Isource[0]['sourceName'] =
	$_SESSION['image']['sourceType0'] = $Isource[0]['sourceType'] =
	$_SESSION['image']['source0'] = $Isource[0]['source'] =
	$_SESSION['image']['updated'] = '';
	$_SESSION['image']['legacyId'] = '';
	$_SESSION['image']['fileFormat'] = '';
	
	
	// -----------
	//	Updated
	// -----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.image 
				WHERE id = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	while ($row = $result->fetch_assoc()) {

		$_SESSION['image']['updated'] = 'Last updated: ' . date('D, M j, Y, h:i a', strtotime($row['last_update'])) . ' by '. $row['last_update_by'];

		$_SESSION['image']['legacyId'] = $row['legacy_id'];
		$_SESSION['image']['fileFormat'] = $row['file_format'];
	}
	 
	// -----------
	//	Title
	// -----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.title 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['titleType'.$i] = $Ititle[$i]['titleType'] = $row['title_type'];
		$_SESSION['image']['title'.$i] = $Ititle[$i]['title'] = $row['title_text'];
		$_SESSION['image']['titleDisplay'.$i] = $Ititle[$i]['titleDisplay'] = $row['display'];
		$i ++;
	}
	
	// ----------
	//	Agent
	// ----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.agent 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['agentAttribution'.$i] = $Iagent[$i]['agentAttribution'] = $row['agent_attribution'];
		$_SESSION['image']['agent'.$i] = $Iagent[$i]['agent'] = $row['agent_text'];
		$_SESSION['image']['agentType'.$i] = $Iagent[$i]['agentType'] = $row['agent_type'];
		$_SESSION['image']['agentRole'.$i] = $Iagent[$i]['agentRole'] = $row['agent_role'];
		$_SESSION['image']['agentId'.$i] = $Iagent[$i]['agentId'] = $row['agent_getty_id'];
		$_SESSION['image']['agentDisplay'.$i] = $Ititle[$i]['agentDisplay'] = $row['display'];
		$i ++;
	}
	
	// ----------
	//	Date
	// ----------
	
	$sql = "SELECT * 
				FROM $DB_NAME.date 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['dateType'.$i] = $Idate[$i]['dateType'] = $row['date_type'];
		$_SESSION['image']['dateRange'.$i] = $Idate[$i]['dateRange'] = $row['date_range'];
		$_SESSION['image']['circaDate'.$i] = $Idate[$i]['circaDate'] = $row['date_circa'];
		$_SESSION['image']['startDate'.$i] = $Idate[$i]['startDate'] = $row['date_text'];
		$_SESSION['image']['startDateEra'.$i] = $Idate[$i]['startDateEra'] = $row['date_era'];
		$_SESSION['image']['endDate'.$i] = $Idate[$i]['endDate'] = $row['enddate_text'];
		$_SESSION['image']['endDateEra'.$i] = $Idate[$i]['endDateEra'] = $row['enddate_era'];
		$_SESSION['image']['dateDisplay'.$i] = $Ititle[$i]['dateDisplay'] = $row['display'];
		$i ++;
	}
	
	// --------------
	//	Material
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.material 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['materialType'.$i] = $Imaterial[$i]['materialType'] = $row['material_type'];
		$_SESSION['image']['material'.$i] = $Imaterial[$i]['material'] = $row['material_text'];
		$_SESSION['image']['materialId'.$i] = $Imaterial[$i]['materialId'] = $row['material_getty_id'];
		$_SESSION['image']['materialDisplay'.$i] = $Ititle[$i]['materialDisplay'] = $row['display'];
		$i ++;
	}
	
	// ---------------
	//	Technique
	// ---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.technique 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['technique'.$i] = $Itechnique[$i]['technique'] = $row['technique_text'];
		$_SESSION['image']['techniqueId'.$i] = $Itechnique[$i]['techniqueId'] = $row['technique_getty_id'];
		$_SESSION['image']['techniqueDisplay'.$i] = $Ititle[$i]['techniqueDisplay'] = $row['display'];
		$i ++;
	}
	
	// ---------------
	//	Work Type
	// ---------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.work_type 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['workType'.$i] = $IworkType[$i]['workType'] = $row['work_type_text'];
		$_SESSION['image']['workTypeId'.$i] = $IworkType[$i]['workTypeId'] = $row['work_type_getty_id'];
		$_SESSION['image']['workTypeDisplay'.$i] = $Ititle[$i]['workTypeDisplay'] = $row['display'];
		$i ++;
	}
	
	// ----------------------
	//	Cultural Context
	// ----------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.culture 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['culturalContext'.$i] = $IculturalContext[$i]['culturalContext'] = $row['culture_text'];
		$_SESSION['image']['culturalContextId'.$i] = $IculturalContext[$i]['culturalContextId'] = $row['culture_getty_id'];
		$_SESSION['image']['culturalContextDisplay'.$i] = $Ititle[$i]['culturalContextDisplay'] = $row['display'];
		$i ++;
	}
	
	// ------------------
	//	Style Period
	// ------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.style_period 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['stylePeriod'.$i] = $IstylePeriod[$i]['stylePeriod'] = $row['style_period_text'];
		$_SESSION['image']['stylePeriodId'.$i] = $IstylePeriod[$i]['stylePeriodId'] = $row['style_period_getty_id'];
		$_SESSION['image']['stylePeriodDisplay'.$i] = $Ititle[$i]['stylePeriodDisplay'] = $row['display'];
		$i ++;
	}
	
	// -------------
	//	Location
	// -------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.location 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['location'.$i] = $Ilocation[$i]['location'] = $row['location_text'];
		$_SESSION['image']['locationId'.$i] = $Ilocation[$i]['locationId'] = $row['location_getty_id'];
		$_SESSION['image']['locationNameType'.$i] = $Ilocation[$i]['locationNameType'] = $row['location_name_type'];
		$_SESSION['image']['locationType'.$i] = $Ilocation[$i]['locationType'] = $row['location_type'];
		$_SESSION['image']['locationDisplay'.$i] = $Ititle[$i]['locationDisplay'] = $row['display'];
		$i ++;
	}
	
	// -----------------
	//	Description
	// -----------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.image 
				WHERE id = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['description0'] = $Idescription0 = $row['description'];
	}
	
	// -------------------
	//	State/Edition
	// -------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.edition 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['stateEditionType'.$i] = $IstateEdition[$i]['stateEditionType'] = $row['edition_type'];
		$_SESSION['image']['stateEdition'.$i] = $IstateEdition[$i]['stateEdition'] = $row['edition_text'];
		$i ++;
	}
	
	// -------------------
	//	Measurements
	// -------------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.measurements 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['measurementType'.$i] = $Imeasurements[$i]['measurementType'] = $row['measurements_type'];
		$_SESSION['image']['measurementField1_'.$i] = $Imeasurements[$i]['measurementField1_'] = $row['measurements_text'];
		$_SESSION['image']['commonMeasurementList1_'.$i] = $Imeasurements[$i]['commonMeasurementList1_'] = $row['measurements_unit'];
		$_SESSION['image']['measurementField2_'.$i] = $Imeasurements[$i]['measurementField2_'] = $row['measurements_text_2'];
		$_SESSION['image']['commonMeasurementList2_'.$i] = $Imeasurements[$i]['commonMeasurementList2_'] = $row['measurements_unit_2'];
		$_SESSION['image']['inchesValue'.$i] = $Imeasurements[$i]['inchesValue'] = $row['inches_value'];
		$_SESSION['image']['areaMeasurementList'.$i] = $Imeasurements[$i]['areaMeasurementList'] = $row['area_unit'];
		$_SESSION['image']['days'.$i] = $Imeasurements[$i]['days'] = $row['duration_days'];
		$_SESSION['image']['hours'.$i] = $Imeasurements[$i]['hours'] = $row['duration_hours'];
		$_SESSION['image']['minutes'.$i] = $Imeasurements[$i]['minutes'] = $row['duration_minutes'];
		$_SESSION['image']['seconds'.$i] = $Imeasurements[$i]['seconds'] = $row['duration_seconds'];
		$_SESSION['image']['fileSize'.$i] = $Imeasurements[$i]['fileSize'] = $row['filesize_unit'];
		$_SESSION['image']['resolutionWidth'.$i] = $Imeasurements[$i]['resolutionWidth'] = $row['resolution_width'];
		$_SESSION['image']['resolutionHeight'.$i] = $Imeasurements[$i]['resolutionHeight'] = $row['resolution_height'];
		$_SESSION['image']['weightUnit'.$i] = $Imeasurements[$i]['weightUnit'] = $row['weight_unit'];
		$_SESSION['image']['otherMeasurementDescription'.$i] = $Imeasurements[$i]['otherMeasurementDescription'] = $row['measurements_description'];
		$_SESSION['image']['measurementDisplay'.$i] = $Ititle[$i]['measurementDisplay'] = $row['display'];
		$i ++;
	}
	
	// --------------
	//	Subject
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.subject 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['subjectType'.$i] = $Isubject[$i]['subjectType'] = $row['subject_type'];
		$_SESSION['image']['subject'.$i] = $Isubject[$i]['subject'] = $row['subject_text'];
		$_SESSION['image']['subjectId'.$i] = $Isubject[$i]['subjectId'] = $row['subject_getty_id'];
		$_SESSION['image']['subjectDisplay'.$i] = $Ititle[$i]['subjectDisplay'] = $row['display'];
		$i ++;
	}
	
	// -----------------
	//	Inscription
	// -----------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.inscription 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['inscriptionType'.$i] = $Iinscription[$i]['inscriptionType'] = $row['inscription_type'];
		$_SESSION['image']['workInscription'.$i] = $Iinscription[$i]['workInscription'] = $row['inscription_text'];
		$_SESSION['image']['workInscriptionAuthor'.$i] = $Iinscription[$i]['workInscriptionAuthor'] = $row['inscription_author'];
		$_SESSION['image']['workInscriptionLocation'.$i] = $Iinscription[$i]['workInscriptionLocation'] = $row['inscription_location'];
		$_SESSION['image']['inscriptionDisplay'.$i] = $Ititle[$i]['inscriptionDisplay'] = $row['display'];
		$i ++;
	}
	
	// --------------
	//	Rights
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.rights 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['rightsType'.$i] = $Irights[$i]['rightsType'] = $row['rights_type'];
		$_SESSION['image']['rightsHolder'.$i] = $Irights[$i]['rightsHolder'] = $row['rights_holder'];
		$_SESSION['image']['rightsText'.$i] = $Irights[$i]['rightsText'] = $row['rights_text'];
		$i ++;
	}
	
	// --------------
	//	Source
	// --------------
	
	$sql = "SELECT * 
				FROM $DB_NAME.source 
				WHERE related_images = '{$_SESSION['imageNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		$_SESSION['image']['sourceNameType'.$i] = $Isource[$i]['sourceNameType'] = $row['source_name_type'];
		$_SESSION['image']['sourceName'.$i] = $Isource[$i]['sourceName'] = $row['source_name_text'];
		$_SESSION['image']['sourceType'.$i] = $Isource[$i]['sourceType'] = $row['source_type'];
		$_SESSION['image']['source'.$i] = $Isource[$i]['source'] = $row['source_text'];
		
		if ($_SESSION['workNum'] == 'new')
		{
		// Work is new, so import work source (textref) info from the image record
		
			$_SESSION['work']['sourceNameType'.$i] = $Wsource[$i]['sourceNameType'] = $row['source_name_type'];
			$_SESSION['work']['sourceName'.$i] = $Wsource[$i]['sourceName'] = $row['source_name_text'];
			$_SESSION['work']['sourceType'.$i] = $Wsource[$i]['sourceType'] = $row['source_type'];
			$_SESSION['work']['source'.$i] = $Wsource[$i]['source'] = $row['source_text'];
		}
		
		$i ++;
	}
	
}

	// Define image_viewer parameter based on legacy id

	$imageView = $_SESSION['image']['legacyId']; 

	//Truncate Legacy Id for style intrusion if needed
	$truncView = (strlen($imageView) > 25) 
				? substr($imageView, 0, 25) . '...' 
				: $imageView;

	$privEdit = $_SESSION['priv_image_ids_edit'];	

include('../_php/_order/query_image.php');?>

<script>

//Add image number to header and allow legacy id edit

	var imageView = '<?php echo $imageView; ?>';
	var truncView = '<?php echo $truncView; ?>';

	var imageNum = "<?php echo $_SESSION['imageNum'];?>";
	var orderNum = "<?php echo $_SESSION['order']; ?>";

	$('div#image_module h1').append('<div id="imageId" class="floatRight">' + truncView + '</div>');
	$('div#imageId').addClass('pointer');
	$('div#imageId').click(function() {		 

		if ('<?php echo $privEdit;?>' == '1') {

			$(this).hide();
			editId_form(imageView, imageNum, orderNum);	
		}

		else {
			msg(['Special privileges are required to change the image id.'], 'error');
		}
	});
</script>

<div class="imageRecord_catalogInfo">

	<div class="record_updateInfo grey mediumWeight">

		<div style="margin-bottom: 8px;">
			CREATED:<br>
			<?php echo strtoupper(date('D, M d, Y', strtotime($date_created))); ?> by <?php echo strtoupper($created_by); ?>
		</div>

		<div style="margin-bottom: 8px;">
			UPDATED:<br>
			<?php echo strtoupper(date('D, M d, Y', strtotime($last_update))); ?> by <?php echo strtoupper($last_update_by); ?>
		</div>

		<?php if ($_SESSION['priv_catalog'] == '1') { ?>

			<a id="editCatalog"
				title="Edit the catalog">

				<img src="_assets/_images/page_white_edit.png" 
					style="height: 20px; width: 20px;">

			</a>

		<?php } ?>

		<?php if ($_SESSION['priv_orders_read'] == '1') { ?>

			<a id="viewOrder"
				title="Go to order">

				<img src="_assets/_images/table_go.png" 
					style="height: 20px; width: 20px;">

			</a>

		<?php } ?>

	</div>

	<div class="imageRecord_thumb"
		style="position: absolute; top: 0; right: 0;">

		<?php 
				// Define filepath for thumbnail

				$img_file = $webroot.'/'.$image_src.'/thumb/'.$_SESSION['image']['legacyId'].$_SESSION['image']['fileFormat']; 

				// Perform only for first image in the order
					$thumbs_available = checkRemoteFile($img_file);
		
				
				if ($thumbs_available) { 
				// If imagepath of first image was found ?>

					<img style="vertical-align: top; height: 100%;"
						src="<?php echo $img_file; ?>">

				<?php } else { ?>

					<img style="vertical-align: top; height: 100%;" 
						src="_assets/_images/_missing.jpg">

				<?php } ?>

			</div>


	<p class="clear"></p>
	
	<!--
		Title
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Title:</div>

		<div class="content_lineText mediumWeight"><?php
			if (!empty($imageTitles)) {
				foreach ($imageTitles as $datum) {
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
			if (!empty($imageAgents)) {
				foreach ($imageAgents as $datum) {
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
			if (!empty($imageDates)) {
				foreach ($imageDates as $datum) {
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
			if (!empty($imageMaterials)) {
				foreach ($imageMaterials as $datum) {
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
			if (!empty($imageTechniques)) {
				foreach ($imageTechniques as $datum) {
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
			if (!empty($imageWorkTypes)) {
				foreach ($imageWorkTypes as $datum) {
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
			if (!empty($imageCultures)) {
				foreach ($imageCultures as $datum) {
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
			if (!empty($imageStylePeriods)) {
				foreach ($imageStylePeriods as $datum) {
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
			if (!empty($imageLocations)) {
				foreach ($imageLocations as $datum) {
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
			echo (!empty($imageDescription)) ? $imageDescription : 'None';
		?></div>

	</div>

	<!--
		State/Edition
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Edition:</div>

		<div class="content_lineText"><?php
			if (!empty($imageEditions)) {
				foreach ($imageEditions as $disp) {
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
			if (!empty($imageMeasurements)) {
				foreach ($imageMeasurements as $datum) {
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
			if (!empty($imageSubjects)) {
				foreach ($imageSubjects as $datum) {
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
			if (!empty($imageInscriptions)) {
				foreach ($imageInscriptions as $datum) {
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
			if (!empty($imageRights)) { foreach ($imageRights as $rights) { echo $rights . '<br>'; } }
		?></div>

	</div>
	
	<!--
		Sources
	-->
	
	<div class="content_line">

		<div class="content_lineTitle">Source:</div>

		<div class="content_lineText"><?php
			if (!empty($imageSources)) { foreach ($imageSources as $source) { echo $source . '<br>'; } }
		?></div>

	</div>

</div>

<script>

	//-----------------------------
	//	 Click to edit the catalog
	//-----------------------------

	$('a#editCatalog').click(
		function()
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


	//-----------------------
	//  Click to view order
	//-----------------------

	$('a#viewOrder').click(
		function()
		{
			var orderNum = "<?php echo $_SESSION['order']; ?>";
			open_order(orderNum);
		});

	//-----------------------
	//  Click to view image
	//-----------------------

	$('div.imageRecord_thumb').click(
		function()
		{
			image_viewer(imageView);

		});

</script>