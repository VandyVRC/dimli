<?php
require_priv('priv_catalog');

$timestamp = date('Y-m-d H:i:s');

$recordType = 'createNewWork'; // Used to differentiate between 'work' and 'createNewWork' arrays in included "update_db.php"
$workDescription = mysql_real_escape_string($_SESSION['descriptionArray']['createNewWork']['NWdescription0']);

$query = " INSERT INTO dimli.work
				SET
					description = '{$workDescription}',
					last_update = '{$timestamp}',
					last_update_by = '{$_SESSION['username']}',
					created = '{$timestamp}',
					created_by = '{$_SESSION['username']}'
		";
$result = mysql_query($query, $connection); confirm_query($result);
// Create the new work


// Find the ID number of the new work
//Apr17 $query = " SELECT id FROM dimli.work ORDER BY id DESC LIMIT 1 ";
//Apr17 $result = mysql_query($query, $connection); confirm_query($result);
$recordNum = create_six_digits(mysql_insert_id());

require('../_php/update_db.php');
?>
