<?php
require_priv('priv_catalog');

$timestamp = date('Y-m-d H:i:s');

$recordType = 'createNewWork'; // Used to differentiate between 'work' and 'createNewWork' arrays in included "update_db.php"
$workDescription = $_SESSION['descriptionArray']['createNewWork']['NWdescription0'];


// Create the new work record

$sql = "INSERT INTO $DB_NAME.work
				SET description = '{$workDescription}',
					last_update = '{$timestamp}',
					last_update_by = '{$_SESSION['username']}',
					created = '{$timestamp}',
					created_by = '{$_SESSION['username']}' ";

$result = db_query($mysqli, $sql);


// Find the six-digit id number of the new work
$recordNum = create_six_digits($mysqli->insert_id);

require('../_php/update_db.php');
?>
