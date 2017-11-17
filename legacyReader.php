<?php  
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

$errors = array(); $message = '';

if (!isset($_SESSION['legReader_currentRecord'])) {
// User has not yet visited a legReader record this session

	$sql = "SELECT last_legReader 
				FROM DB_NAME.user 
				WHERE id = '{$_SESSION['user_id']}' ";

	$result6 = db_query($mysqli, $sql);

	while ($row = $result6->fetch_assoc()) {
		$lastLegReader = $row['last_legReader'];
	}
	
	if ($lastLegReader != '0') {
	// User has a 'last_legReader' number saved in their user record
	
		$_SESSION['legReader_currentRecord'] = create_six_digits($lastLegReader);
		
	} else {
	// User has never visited the legReader

		$_SESSION['legReader_currentRecord'] = create_six_digits('1');
		// Set record number to 1 by default
		
	}
	
	$sql = "SELECT * 
				FROM DB_NAME.legacy 
				WHERE resource = '{$_SESSION['legReader_currentRecord']}' ";

	$result = db_query($mysqli, $sql);
	
}

if (isset($_POST['legacyReader-prev']) && $_POST['legacyReader-prev'] == 'Prev') {
// User clicked previous

	if ($_SESSION['legReader_currentRecord'] != '000001') {
	// User is not attempting to go backward from the first record
	
		$_SESSION['legReader_currentRecord']--;
		$_SESSION['legReader_currentRecord'] = create_six_digits($_SESSION['legReader_currentRecord']);

		$sql = "SELECT * 
					FROM DB_NAME.legacy 
					WHERE resource = '{$_SESSION['legReader_currentRecord']}' ";

		$result = db_query($mysqli, $sql);
		
	} else {
	// User is already at record 000001
	
		$sql = "SELECT * 
					FROM DB_NAME.legacy 
					WHERE resource = '{$_SESSION['legReader_currentRecord']}' ";

		$result = db_query($mysqli, $sql);
	
	}

} elseif (isset($_POST['legacyReader-next']) && $_POST['legacyReader-next'] == 'Next') {
// User clicked Next

	$_SESSION['legReader_currentRecord']++;
	$_SESSION['legReader_currentRecord'] = create_six_digits($_SESSION['legReader_currentRecord']);

	$sql = "SELECT * 
				FROM DB_NAME.legacy 
				WHERE resource = '{$_SESSION['legReader_currentRecord']}' ";

	$result = db_query($mysqli, $sql);
	
} elseif (isset($_POST['legacyReader-jumpToRecord']) && $_POST['legacyReader-jumpToRecord'] == 'Go') {
// User performed a manual record search

	$sql = "SELECT * 
				FROM DB_NAME.legacy 
				WHERE resource = '{$_POST['legacyReader-recordNum']}' ";

	$result = db_query($mysqli, $sql);
	
	$_SESSION['legReader_currentRecord'] = $_POST['legacyReader-recordNum'];

} else {

	$sql = "SELECT * 
				FROM DB_NAME.legacy 
				WHERE resource = '{$_SESSION['legReader_currentRecord']}' ";

	$result = db_query($mysqli, $sql);

}

//------------------------------------------------
//		Update User's 'last_legReader' number
//------------------------------------------------

$sql = "UPDATE DB_NAME.user 
			SET last_legReader = '{$_SESSION['legReader_currentRecord']}' 
			WHERE id = '{$_SESSION['user_id']}' ";

$result5 = db_query($mysqli, $sql);
// Update current user's 'last_legReader' number for quick navigation

//------------------------------
//		Update Lecture Tag
//------------------------------

if (isset($_POST['submit-lectureTag']) && $_POST['submit-lectureTag'] == 'Update Lecture Tag') {

	$fieldsWithMaxLengths = array('lectureTag'=>255);
	$errors = array_merge($errors, check_max_field_lengths($fieldsWithMaxLengths));
	// Validate max field length
	
	$sql = "DELETE FROM DB_NAME.lecture_tag 
				WHERE related_image = '{$_SESSION['legReader_currentRecord']}' ";

	$result2 = db_query($mysqli, $sql);
	// Delete old tags associated with this image
	
	$lectureTagString = mysql_prep(trim($_POST['lectureTag'], ' ,;'));
	$lectureTagArray = array_filter(explode(',', $lectureTagString), 'notEmpty');
	$timestamp = date('Y-m-d H:i:s');
	
	foreach ($lectureTagArray as $tag) {
	
		$tag = trim($tag, ' ,');

		$sql = " INSERT INTO DB_NAME.lecture_tag
						SET related_image = '{$_SESSION['legReader_currentRecord']}',
							text = '{$tag}',
							last_update_by = '{$_SESSION['username']}',
							last_update_on = '{$timestamp}' ";

		$result3 = db_query($mysqli, $sql);
		// Add new tag
	
	}

}

//------------------------------------------
//		Retrieve Current Lecture Tag(s)
//------------------------------------------

$sql = "SELECT text 
			FROM DB_NAME.lecture_tag 
			WHERE related_image = '{$_SESSION['legReader_currentRecord']}' ";

$result4 = db_query($mysqli, $sql);

$currentTags = '';
while ($row = $result4->fetch_assoc()) {
	$currentTags .= $row['text'] . ', ';
}
$currentTags = trim($currentTags, ' ,');

//-----------------------------------------
//		Find recently visited order
//-----------------------------------------

$query_recentOrder = "SELECT last_order 
								FROM DB_NAME.user 
								WHERE username = '{$_SESSION['username']}' ";

$result_recentOrder = db_query($mysqli, $query_recentOrder);

while ($recent_order = $result_recentOrder->fetch_assoc()) {
	$lastOrder = create_four_digits($recent_order['last_order']);
}

#################################################################
#####################  BEGIN CLIENT-SIDE  #######################
#################################################################
require("_php/header.php"); ?>

<!-- Pane container -->
<div id="paneContainer">

	<div class="pane">

	<div class="floatRight" style="right: 40px; top: 40px; maxheight: 80px; margin-top: 15px;">

		<img src="hartstor/HoAC/medium/<?php echo $_SESSION['legReader_currentRecord']; ?>.jpg" 
			style="max-height: 150px;">

	</div>

	<form id="legacyReader-form" 
		method="post" 
		action="legacyReader.php" 
		style="padding-left: 60px;">

		<input type="submit" 
			id="legacyReader-prev" 
			name="legacyReader-prev" 
			value="Prev">

		<input type="text" 
			id="legacyReader-recordNum" 
			name="legacyReader-recordNum" 
			value="<?php echo htmlentities($_SESSION['legReader_currentRecord']); ?>" style="font-size: 18px; color: #000;" 
			maxlength="6">

		<input type="submit" 
			id="legacyReader-jumpToRecord" 
			name="legacyReader-jumpToRecord" 
			value="Go">

		<input type="submit" 
			id="legacyReader-next" 
			name="legacyReader-next" 
			value="Next">

	</form>

		<table id="legacyReader-table" 
			style="font-size: 0.9em;">
			
			<?php if (isset($result) && $result->num_rows != 0) { ?>
			<!-- A record was found in the legacy table -->

				<?php while ($row = $result->fetch_assoc()) { ?>
				
					<tr>
						<td class="lr-titleCell">
						
							Title:
						
						</td>
						
						<td style="font-size: 14px;">
						
							<?php echo $row['Title']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Agent:
						
						</td>
						
						<td>
						
							<?php echo $row['CreatorArtist']; ?>
						
						</td>
					</tr>
					
					<?php if (!empty($row['CreatorPhotographer'])) { ?>
					
						<tr>
							<td class="lr-titleCell">
							
								Agent (photographer):
							
							</td>
							
							<td>
							
								<?php echo $row['CreatorPhotographer']; ?>
							
							</td>
						</tr>
						
					<?php } ?>
					
					<tr>
						<td class="lr-titleCell">
						
							Date:
						
						</td>
						
						<td>
						
							<?php echo $row['DateCreation']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Material:
						
						</td>
						
						<td>
						
							<?php echo $row['MaterialMedium']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Culture:
						
						</td>
						
						<td>
						
							<?php echo $row['Culture']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Style period:
						
						</td>
						
						<td>
						
							<?php echo $row['StylePeriod']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Location (country):
						
						</td>
						
						<td>
						
							<?php echo $row['LocationCountry']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Location (current):
						
						</td>
						
						<td>
						
							<?php echo $row['LocationCurrentSite']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Location (creation):
						
						</td>
						
						<td>
						
							<?php echo $row['LocationCreationSite']; ?>
						
						</td>
					</tr>
					
					<tr style="border-top: 1px dashed #CCC;">
						<td class="lr-titleCell">
						
							Description (image title):
						
						</td>
						
						<td>
						
							<?php echo $row['VUtemp_ImageTitle']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Description (larger entity title):
						
						</td>
						
						<td>
						
							<?php echo $row['TitleLargerEntity']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Description (description):
						
						</td>
						
						<td>
						
							<?php echo $row['Description']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Description (notes):
						
						</td>
						
						<td>
						
							<?php echo $row['Notes']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Description (staff notes):
						
						</td>
						
						<td>
						
							<?php echo $row['StaffNotes']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Description (keywords):
						
						</td>
						
						<td>
						
							<?php echo $row['VUtemp_keywords']; ?>
						
						</td>
					</tr>
					
					<tr style="border-top: 1px dashed #CCC;">
						<td class="lr-titleCell">
						
							Measurements:
						
						</td>
						
						<td>
						
							<?php echo $row['MeasurementDimension']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Rights (rights holder):
						
						</td>
						
						<td>
						
							<?php echo $row['RightsHolder']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Rights (copyright status):
						
						</td>
						
						<td>
						
							<?php echo $row['CopyrightStatus']; ?>
						
						</td>
					</tr>
					
					<tr style="border-top: 1px dashed #CCC;">
						<td class="lr-titleCell">
						
							Source (title):
						
						</td>
						
						<td>
						
							<i><?php echo $row['SourceTitle']; ?></i>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Source (author):
						
						</td>
						
						<td>
						
							<?php echo $row['SourceCitationDetail']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Source (pub info):
						
						</td>
						
						<td>
						
							<?php if (!empty($row['SourcePubCity']) || !empty($row['SourcePublisher']) || !empty($row['SourcePubYear'])) { ?>
						
								<?php echo $row['SourcePubCity'] . ': ' . $row['SourcePublisher'] . ' (' . $row['SourcePubYear'] . ')'; ?>
							
							<?php } ?>
						
						</td>
					</tr>
						
					<tr>
						<td class="lr-titleCell">
						
							Source (page no.):
						
						</td>
						
						<td>
						
							<?php echo $row['SourcePage']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Source (copyright statement):
						
						</td>
						
						<td>
						
							<?php echo $row['CreatorArtist']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Source (ISBN):
						
						</td>
						
						<td>
						
							<?php echo $row['SourceISBN']; ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Source (call no.):
						
						</td>
						
						<td>
						
							<?php echo $row['SourceCallNo']; ?>
						
						</td>
					</tr>
					
					
				
				<?php } ?>

			<?php } else { ?>
			<!-- No record was found in the legacy table -->

				<tr><td>No legacy record exists for ID number <?php echo $_SESSION['legReader_currentRecord']; ?></td></tr>

			<?php } ?>
			
			
			
					<!--
						Update Lecture Tags
					-->
					
					<tr style="border-top: 1px dashed #CCC;">
						<td class="lr-titleCell">
						
							Lecture tag (legacy):
						
						</td>
						
						<td>
						
							<?php
								echo (!empty($row['Class'])) ? $row['Class'] : '';
								echo (!empty($row['Class']) && !empty($row['ClassLectureTag'])) 
									? ' || ' 
									: '';
								echo (!empty($row['ClassLectureTag'])) ? $row['ClassLectureTag'] : '';
							?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell">
						
							Lecture tag (current):
						
						</td>
						
						<td>
						
							<?php echoValue($currentTags); ?>
						
						</td>
					</tr>
					
					<tr>
						<td class="lr-titleCell"></td>
					
						<td>
					
							<form method="post" action="">
						
							<input type="text" id="lectureTag" name="lectureTag" value="<?php echo htmlentities($currentTags); ?>" style="width: 450px; padding: 6px 4px;">
							<input type="submit" class="submit" name="submit-lectureTag" value="Update Lecture Tag" style="margin-bottom: 10px;">
							
							</form>
					
						</td>
					</tr>

		</table>
	
	</div> <!-- pane -->

</div> <!-- paneContainer -->

<?php require("_php/footer.php"); ?>