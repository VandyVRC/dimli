<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../_php/_config/session.php');
require_once(MAIN_DIR.'/../_php/_config/connection.php');
require_once(MAIN_DIR.'/../_php/_config/functions.php');

confirm_logged_in();

$imageViewer_imageNum = $_GET['imageNum'];
?>

<div id="screen"></div>

<div id="imagePort-vertical">

	<div id="imagePort-holder">

		<?php
		$imagePort_file = $image_dir.'medium/'.$imageViewer_imageNum.'.jpg';

		?>

		<img src="<?php echo $imagePort_file; ?>">

	</div>

</div>

<script>

	$('div#screen, div#imagePort-vertical').bind('click', function()
	{
		$('div#screen')
			.add('div#imagePort-vertical')
			.remove();
	});

</script>

