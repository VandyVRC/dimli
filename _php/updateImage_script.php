<?php
require_priv('priv_catalog');

$recordNum = $_SESSION['imageNum'];
$recordType = 'image';
$imageDescription = $_SESSION['descriptionArray']['image']['Idescription0'];
$UnixTime = time(TRUE);

if ($_SESSION['workNum'] != 'None')
// Related work already exists
{

	$sql = "UPDATE dimli.image
				SET related_works = '{$_SESSION['workNum']}',
					description = '{$imageDescription}',
					catalogued = '1',
					last_update = '{$timestamp}',
					last_update_by = '{$_SESSION['username']}',
					flagged_for_export = '1'
				WHERE id = '{$recordNum}' ";

	$result = db_query($mysqli, $sql);
	// Update description in IMAGE table
	// Using existing related work ID

}
elseif ($_SESSION['workNum'] == 'None')
// There is NO existing related work
{

	$sql = "UPDATE dimli.image
				SET related_works = '{$newWorkNum}',
					description = '{$imageDescription}',
					catalogued = '1',
					last_update = '{$timestamp}',
					last_update_by = '{$_SESSION['username']}',
					flagged_for_export = '1'
				WHERE id = '{$recordNum}' ";

	$result = db_query($mysqli, $sql);
	// Update description in IMAGE table
	// Using next available work ID

}

//--------------
//  Log action
//--------------

$sql = "INSERT INTO dimli.Activity
			SET UserID = '{$_SESSION['user_id']}',
				RecordType = 'Image',
				RecordNumber = {$recordNum},
				ActivityType = 'modified',
				UnixTime = '{$UnixTime}' ";

$result = db_query($mysqli, $sql);

//------------------------------------
//  Continue to update the database
//------------------------------------

require('../_php/update_db.php');