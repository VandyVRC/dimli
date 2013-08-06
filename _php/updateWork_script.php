<?php
require_priv('priv_catalog');

$timestamp = date('Y-m-d H:i:s');
$UnixTime = time(TRUE);

// echo 'Work: '.$_SESSION['workNum'].'<br>'; // Debug
// echo 'Image: '.$_SESSION['imageNum']; // Debug

$recordType = 'work'; // Used to differentiate between 'work' and 'createNewWork' arrays in each data type loop below

$workDescription = $_SESSION['descriptionArray']['work']['Wdescription0'];

if ($_SESSION['workNum'] == 'None' || $_SESSION['workNum'] == '')
// An associated work DOES NOT already EXIST
// So CREATE NEW work record
{
	$query = " INSERT INTO dimli.work
			SET
				related_images = '{$_SESSION['imageNum']}',
				preferred_image = '{$_SESSION['imageNum']}',
				description = '{$workDescription}',
				last_update = '{$timestamp}',
				last_update_by = '{$_SESSION['username']}',
				created = '{$timestamp}',
				created_by = '{$_SESSION['username']}'
			";
	$result = mysql_query($query, $connection); confirm_query($result);
	
	$recordNum = create_six_digits(mysql_insert_id());
	$newWorkNum = create_six_digits(mysql_insert_id());
	$_SESSION['workNum'] = create_six_digits(mysql_insert_id());
	$_SESSION['shortWorkNum'] = ltrim($_SESSION['workNum'], '0');
	// Define the ID number of the new work

	/*
	LOG ACTION
	*/
	$ts = date('Y m d H:i:s');
	$log = isnerQ("INSERT INTO dimli.Activity
						SET 
							UserID = '{$_SESSION['user_id']}',
							RecordType = 'Work',
							RecordNumber = {$_SESSION['shortWorkNum']},
							ActivityType = 'created',
							UnixTime = '{$UnixTime}'
						");

}
elseif (strlen($_SESSION['workNum']) == 6)
// An associated work DOES EXIST
// So UPDATE it
{
	$_SESSION['shortWorkNum'] = ltrim($_SESSION['workNum'], '0');

	$query = " SELECT related_images FROM dimli.work WHERE id = '{$_SESSION['shortWorkNum']}' ";
	$result = mysql_query($query, $connection); confirm_query($result);
	
	while ($row = mysql_fetch_assoc($result))
	{
		$existingRelatedImages = $row['related_images'];
		// Find any images already associated with this work
	}
	
	if (!empty($existingRelatedImages))
	// If other images are already associated with this work
	{
	
		$existingRelatedImages = explode(',', $existingRelatedImages);
		
		if (in_array($_SESSION['imageNum'], $existingRelatedImages))
		// If this image is already associated with the work
		{
			// Do nothing
		}
		else
		{
			$query = " UPDATE dimli.work 
					SET 
						related_images = IFNULL(CONCAT(related_images, ',{$_SESSION['imageNum']}'), '{$_SESSION['imageNum']}') 
					WHERE 
						id = '{$_SESSION['shortWorkNum']}'
					";
			$result = mysql_query($query, $connection); confirm_query($result);
			// Add new image to list of associated images in work record
		}
	
	}

	$recordNum = $_SESSION['workNum'];
	// Use existing associated work number for new insert statements
	
	$query = " UPDATE dimli.work
			SET
				description = '{$workDescription}',
				last_update = '{$timestamp}',
				last_update_by = '{$_SESSION['username']}'
			WHERE
				id = '{$_SESSION['shortWorkNum']}'
			";
	$result = mysql_query($query, $connection); confirm_query($result);
	// echo $query.'<br>'; // Debug

	/*
	LOG ACTION
	*/
	$log = isnerQ("INSERT INTO dimli.Activity
						SET 
							UserID = '{$_SESSION['user_id']}',
							RecordType = 'Work',
							RecordNumber = {$_SESSION['shortWorkNum']},
							ActivityType = 'modified',
							UnixTime = '{$UnixTime}'
						");

}

require('../_php/update_db.php');

?>