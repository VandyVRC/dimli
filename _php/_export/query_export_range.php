<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_csv_export');

$first = $_GET['firstExportRecord'];
$last = $_GET['lastExportRecord'];

	$sql = "SELECT id FROM $DB_NAME.image 
				WHERE legacy_id = '{$first}'";
		$result = db_query($mysqli, $sql);	

			if ($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
				$first = ($row['id']);
				}
			}
			else {
				
				$first = 0;
			}

		$sql = "SELECT id FROM $DB_NAME.image 
				WHERE legacy_id = '{$last}'";	
			$result = db_query($mysqli, $sql);	
			
			if ($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
				$last = ($row['id']);
				}
			} 
			else { 

				$last = 0;
			}
?>

<script>
var first = '<?php echo $first;?>';
var last = '<?php echo $last;?>';

if (first == 0){

	$('div[id$=_module]').remove();
		msg(['The first image id does not exist'], 'error');
		export_load();
}

else if (last == 0){

	$('div[id$=_module]').remove();
		msg(['The last image id does not exist'], 'error');
		export_load();	
}

else{
	export_range(first, last);

}
	</script>		
	