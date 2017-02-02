<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

$museum = 	$mysqli->real_escape_string(trim($_POST['data']['museum']));
$address = 	$mysqli->real_escape_string(trim($_POST['data']['address']));
$city = 		$mysqli->real_escape_string(trim($_POST['data']['city']));
$state = 	$mysqli->real_escape_string(trim($_POST['data']['state']));
$zip = 		$mysqli->real_escape_string(trim($_POST['data']['zip']));
$region = 	$mysqli->real_escape_string(trim($_POST['data']['region']));
$country = 	$mysqli->real_escape_string(trim($_POST['data']['country']));
$phone = 	$mysqli->real_escape_string(trim($_POST['data']['phone']));
$website = 	$mysqli->real_escape_string(trim($_POST['data']['website']));
$images = 	$mysqli->real_escape_string(trim($_POST['data']['images']));

$sql = "INSERT INTO $DB_NAME.repository
			SET museum = 	'{$museum}',
				address = 	'{$address}',
				city = 		'{$city}',
				state = 	'{$state}',
				zip = 		'{$zip}',
				region = 	'{$region}',
				country = 	'{$country}',
				phone = 	'{$phone}',
				website = 	'{$website}',
				images = 	'{$images}' ";

$result = db_query($mysqli, $sql);

if ($result)
{ ?>

	<script>

		msg(['Repository successfully created','<?php echo $museum;?>'], 'success');

	</script>

<?php
}

// Clear new repository array
$_SESSION['newRepositoryDetails'] = array();

// Debugging
// echo '<pre>'.print_r($_POST['data']).'</pre>';
?>
