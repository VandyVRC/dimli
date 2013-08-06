<?php
$dev = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$dev);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

$museum = 	sql_prep(trim($_POST['data']['museum']));
$address = 	sql_prep(trim($_POST['data']['address']));
$city = 	sql_prep(trim($_POST['data']['city']));
$state = 	sql_prep(trim($_POST['data']['state']));
$zip = 		sql_prep(trim($_POST['data']['zip']));
$region = 	sql_prep(trim($_POST['data']['region']));
$country = 	sql_prep(trim($_POST['data']['country']));
$phone = 	sql_prep(trim($_POST['data']['phone']));
$website = 	sql_prep(trim($_POST['data']['website']));
$images = 	sql_prep(trim($_POST['data']['images']));

$query = " INSERT INTO dimli.repository
					SET
						museum = 	'{$museum}',
						address = 	'{$address}',
						city = 		'{$city}',
						state = 	'{$state}',
						zip = 		'{$zip}',
						region = 	'{$region}',
						country = 	'{$country}',
						phone = 	'{$phone}',
						website = 	'{$website}',
						images = 	'{$images}'
";
$result = mysql_query($query, $connection);
confirm_query($result);

if ($result)
{
	?>
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
