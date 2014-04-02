<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');


confirm_logged_in();
require_priv('priv_orders_download');

if (isset($_GET['order'])) {

	$order = $_GET['order'];

	// Define filepath/name of archive file
	$file = MAIN_DIR.'/../../_ppts/'.$order.'.pptx';

	if (file_exists($file)): // File EXISTS

		// Temporarily increase PHP memory limit
		ini_set('memory_limit', '1024M');

		header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
		header("Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Length: ".filesize($file));
		header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
		ob_clean();
		flush();
		readfile($file);

		// Reset PHP memory limit
		ini_set('memory_limit', '128M');

		exit();

	else: // File DOES NOT exist

		echo 'File: "'.$file.'" not found';

	endif;
}

