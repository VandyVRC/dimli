<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_orders_create');

$newDueDate = $_POST['newDueDate'];
$orderNum = ltrim($_POST['orderNum'], '0');

if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $newDueDate)) {

	$sql = "UPDATE $DB_NAME.order
				SET date_needed = '{$newDueDate}'
				WHERE id = '{$orderNum}' ";

	if ($result = db_query($mysqli, $sql)) { ?>
		<script>msg(['Due date successfully updated'], 'success');</script>

	<?php
	} 

} else { ?>

	<script>msg(['Invalid due date'], 'error');</script>

<?php
}

$sql = "SELECT date_needed
		FROM $DB_NAME.order
		WHERE id = '{$orderNum}' ";

$result = db_query($mysqli, $sql);

while ($row = $result->fetch_assoc()) {
	$dateNeeded = $row['date_needed'];
}

echo date('M j, Y', strtotime($dateNeeded)); ?>
