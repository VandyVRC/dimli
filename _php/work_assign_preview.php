<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();
require_priv('priv_catalog');

$image = $_POST['image'];
$work = $_POST['work'];

$sql = "UPDATE $DB_NAME.work 
			SET preferred_image = '{$image}'
			WHERE id = '{$work}' ";

$result = db_query($mysqli, $sql); ?>

<div class="workRecord_thumb defaultCursor"
	style="position: absolute; top: 0; right: 0;">

	<img src="mdidimages/HoAC/thumb/<?php echo $image; ?>.jpg"
	onclick="image_viewer('<?php echo $image; ?>');">

</div>

<script>

	$('div.assocImage_pref').unbind('click');

	$('div.assocImage_pref:not(.pref)').click(
		function()
		{
			var image = $(this).parents('div.work_assocImage_row')
				.find('a.assocImage_open')
				.text();

			work_assign_preview(image, '<?php echo $_SESSION['workNum'];?>');
			$('div.assocImage_pref').removeClass('pref');
			$(this).addClass('pref');
		});

</script>