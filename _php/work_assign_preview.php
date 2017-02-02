<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();
require_priv('priv_catalog');

$image = $_POST['image'];
$work = $_POST['work'];

$sql = "UPDATE $DB_NAME.work 
			SET preferred_image = '{$image}'
			WHERE id = '{$work}' ";

$result = db_query($mysqli, $sql); 

		
		$sql ="SELECT legacy_id 
					FROM $DB_NAME.image 
					WHERE id ='{$image}'";

					$result_prefLegId = db_query($mysqli, $sql);

				while ($row = $result_prefLegId->fetch_assoc()){
				$prefLegId = $row['legacy_id'];
				}


				?>

<div class="workRecord_thumb defaultCursor"
	style="position: absolute; top: 0; right: 0;">

	<img src="<?php echo $image_dir; echo $prefLegId; ?>.jpg"
	onclick="image_viewer('<?php echo $prefLegId; ?>');">

</div>

<script>

	$('div.assocImage_pref').unbind('click');

	$('div.assocImage_pref:not(.pref)').click(
		function()
		{
			var image = $(this).parents('div.work_assocImage_row')
				.find('div.assocImage_jump')
				.text();

			work_assign_preview(image, '<?php echo $_SESSION['workNum'];?>');
			$('div.assocImage_pref').removeClass('pref');
			$(this).addClass('pref');
		});


</script>
